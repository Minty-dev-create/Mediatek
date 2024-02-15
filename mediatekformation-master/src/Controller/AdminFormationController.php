<?php
namespace App\Controller\AdminFormations;

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


/**
 * Controleur de l'accueil
 *
 * @author emds
 */
class AdminFormationsController extends AbstractController{
      
    const FORMATIONS = 'pages/adminformations.html.twig';
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
     * @Route("/adminformations", name="adminformations")
     * @return Response
     */
  

    public function index(): Response{
        $formations = $this->formationRepository->findAll();
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::FORMATIONS, [
            'formations' => $formations,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/formations/tri/{champ}/{ordre}/{table}", name="formations.sort")
     * @param type $champ
     * @param type $ordre
     * @param type $table
     * @return Response
     */
    public function sort($champ, $ordre, $table=""): Response{
        $formations = $this->formationRepository->findAllOrderBy($champ, $ordre, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::FORMATIONS , [
            'formations' => $formations,
            'categories' => $categories
        ]);
    }
    
    /**
     * @Route("/formations/recherche/{champ}/{table}", name="formations.findallcontain")
     * @param type $champ
     * @param Request $request
     * @param type $table
     * @return Response
     */
    public function findAllContain($champ, Request $request, $table=""): Response{
        $valeur = $request->get("recherche");
        $formations = $this->formationRepository->findByContainValue($champ, $valeur, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::FORMATIONS, [
            'formations' => $formations,
            'categories' => $categories,
            'valeur' => $valeur,
            'table' => $table
        ]);
    }
    
    /**
     * @Route("/formations/formation/{id}", name="formations.showone")
     * @param type $id
     * @return Response
     */
    public function showOne($id): Response{
        $formation = $this->formationRepository->find($id);
        return $this->render("pages/formation.html.twig", [
            'formation' => $formation
        ]);
    }
    
      /**
     * @Route("/admin/suppr/formation/{id}", name="admin.formations.suppr")
     * @param Formation $formation
     * @return Response
     */
    
     public function suppr(Formation $formation): Response{
        $this->formationRepository->remove($formation, true);
        return $this->redirectToRoute("adminformations");
    }

    /**
     * @Route ("/admin/formation/edit/{id}", name="admin.formation.edit")
     * @param Formation $formation
     * @param Request $request
     * @return Response
     */

     public function edit(Formation $formation, Request $request): Response {
       $formFormation = $this-> createForm(FormationType::class, $formation);

       $formFormation-> handleRequest($request);
       if($formFormation-> isSubmitted() && $formFormation->isValid()) {
        $this->formationRepository->add($formation, true);
        return $this->redirectToRoute('adminformations');
       }
     return $this->render("pages/admin.formation.edit.html.twig", [
      'formformation' => $formFormation->createView()
     ]);
     }



     /**
     * @Route ("/admin/edit/formation/ajout", name="adminformationajout")
     * @param Formation $formation
     * @param Request $request
     * @return Response
     */

     public function ajout( Request $request): Response {
        $formation = new Formation();
        $formFormation = $this-> createForm(FormationType::class, $formation);
 
        $formFormation-> handleRequest($request);
        if($formFormation-> isSubmitted() && $formFormation->isValid()) {
         $this->formationRepository->add($formation, true);
         return $this->redirectToRoute('adminformations');
        }
      return $this->render("pages/admin.formation.ajout.html.twig", [
        'formation' => $formation,
       'formformation' => $formFormation->createView()
      ]);
      }
}