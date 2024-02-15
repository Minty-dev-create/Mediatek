<?php
namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Playlist;
use App\Form\PlaylistsType;
use App\Form\FormationType;


/**
 * Description of PlaylistsController
 *
 * @author emds
 */
class AdminPlaylistsController extends AbstractController {
    const PLAYLISTS = "pages/admin.playlists.html.twig";
    /**
     *
     * @var PlaylistRepository
     */
    private $playlistRepository;
    
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
    
    
    public function __construct(PlaylistRepository $playlistRepository,
            CategorieRepository $categorieRepository,
            FormationRepository $formationRespository) {
        $this->playlistRepository = $playlistRepository;
        $this->categorieRepository = $categorieRepository;
        $this->formationRepository = $formationRespository;
    }
    
    /**
     * @Route("/adminplaylists", name="adminplaylists")
     * @return Response
     */
    public function index(): Response{
        $playlists = $this->playlistRepository->findAllOrderByName('ASC');
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::PLAYLISTS, [
            'playlists' => $playlists,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/playlists/tri/{champ}/{ordre}", name="playlists.sort")
     * @param type $champ
     * @param type $ordre
     * @return Response
     */
    public function sort($champ, $ordre): Response{
        switch($champ){
            case "name":
                $playlists = $this->playlistRepository->findAllOrderByName($ordre);
                break;

            case "length":
                $playlists= $this->playlistRepository->findByLength($ordre);
                break;
        }
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::PLAYLISTS, [
            'playlists' => $playlists,
            'categories' => $categories
        ]);
    }
	
    /**
     * @Route("/playlists/recherche/{champ}/{table}", name="playlists.findallcontain")
     * @param type $champ
     * @param Request $request
     * @param type $table
     * @return Response
     */
    public function findAllContain($champ, Request $request, $table=""): Response{
        $valeur = $request->get("recherche");
        $playlists = $this->playlistRepository->findByContainValue($champ, $valeur, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::PLAYLISTS, [
            'playlists' => $playlists,
            'categories' => $categories,
            'valeur' => $valeur,
            'table' => $table
        ]);
    }
    
    /**
     * @Route("/playlists/playlist/{id}", name="playlists.showone")
     * @param type $id
     * @return Response
     */
    public function showOne($id): Response{
        $playlist = $this->playlistRepository->find($id);
        $playlistCategories = $this->categorieRepository->findAllForOnePlaylist($id);
        $playlistFormations = $this->formationRepository->findAllForOnePlaylist($id);
        return $this->render("pages/playlist.html.twig", [
            'playlist' => $playlist,
            'playlistcategories' => $playlistCategories,
            'playlistformations' => $playlistFormations
        ]);
    }
     /**
     * @Route ("/admin/playlist/edit/{id}", name="admin.playlists.edit")
     * @param Playlist $playlist
     * @param Request $request
     * @return Response
     */

     public function edit(Playlist $playlist, Request $request): Response {
        $formPlaylists = $this-> createForm(PlaylistsType::class, $playlist);
 
        $formPlaylists-> handleRequest($request);
        if($formPlaylists-> isSubmitted() && $formPlaylists->isValid()) {
         $this->playlistsRepository->add($playlist, true);
         return $this->redirectToRoute('adminplaylists');
        }
      return $this->render("pages/admin.playlists.edit.html.twig", [
       'formplaylists' => $formPlaylists->createView()
       
      ]);
      }
          /**
    * @Route("/admin/playlist/suppr/{id}", name="adminplaylistsuppr")
    * @param Playlist $playlist
    * @return Response
    */
public function suppr(Playlist $playlist): Response {
  
    if (!$playlist->getFormations()->isEmpty()) {
      
        $this->addFlash('erreur', 
        'Impossible de supprimer cette playlist car elle contient une ou plusieurs formations.');

   
        return $this->redirectToRoute("adminplaylists");
    }

    // Si la playlist n'est pas liée à des formations, la supprimer
    $this->playlistRepository->remove($playlist, true);

    // Rediriger vers la liste des playlists après la suppression
    return $this->redirectToRoute("adminplaylists");
}

 /**
     * @Route ("/admin/playlist/ajout", name="adminplaylistajout")
     * @param Playlist $playlist
     * @param Request $request
     * @return Response
     */

     public function ajout( Request $request): Response {
        $playlist = new Playlist();
        $formPlaylists = $this-> createForm(PlaylistsType::class, $playlist);
 
        $formPlaylists-> handleRequest($request);
        if($formPlaylists-> isSubmitted() && $formPlaylists->isValid()) {
         $this->playlistRepository->add($playlist, true);
         return $this->redirectToRoute('adminplaylists');
        }
      return $this->render("pages/admin.playlist.ajout.html.twig", [
        'playlist' => $playlist,
       'formplaylists' => $formPlaylists->createView()
      ]);
      }
}