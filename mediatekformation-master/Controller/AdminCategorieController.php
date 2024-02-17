<?php
namespace App\Controller ;

use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Formation;
use App\Form\FormationType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use DateTime;
use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
/**
 * Controleur de l'accueil
 *
 * @author emds
 */
class AdminCategorieController extends AbstractController{
      
    const CATEGORIE = 'pages/admin.categorie.html.twig';
    /**
     *
     * @var FormationRepository
     */
    private $formationRepository;
    
 
    /**
     *
     * @var CategorieRepository
     */
    private $categorieRepository;
    

  public function __construct(FormationRepository $formationRepository, CategorieRepository $categorieRepository) {
        $this->formationRepository = $formationRepository;
        $this->categorieRepository= $categorieRepository;
    }
    
    /**
     * @Route("/admincategorie", name="admincategorie")
     * @return Response
     */
  

    public function index(): Response{
        $formations = $this->formationRepository->findAll();
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::CATEGORIE, [
            'formations' => $formations,
            'categories' => $categories
        ]);
    }



      /**
     * @Route("/admin/suppr/categorie/{id}", name="admin.categorie.suppr")
     * @param Categorie $cataegorie
     * @return Response
     */
    public function suppr(Categorie $categorie): Response{
     if (!$categorie->getFormations()->isEmpty()) {
      
        $this->addFlash('erreur', 
        'Impossible de supprimer cette playlist car elle contient une ou plusieurs formations.');

   
        return $this->redirectToRoute("adminplaylists");
    }
    
        $this->categorieRepository->remove($categorie, true);
        return $this->redirectToRoute("admincategorie");
    }



     /**
     * @Route ("/admin/categorie/ajout", name="admincategorieajout")
     * @param Categorie $categorie
     * @param Request $request
     * @return Response
     */

     public function ajout( Request $request): Response {
        $nomCategorie = $request->get('nom');
        $categorie = new Categorie();
        $categorie->setName($nomCategorie);
        $this->categorieRepository->add($categorie, true);
        return $this->redirectToRoute('admincategorie');
      }
}