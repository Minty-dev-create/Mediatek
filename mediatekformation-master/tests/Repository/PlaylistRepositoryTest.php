<?php


namespace App\Tests\Repository;

use App\Entity\Playlist;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PlaylistRepositoryTest extends KernelTestCase
{
    // Récupération du Repository Playlist

    public function recupRepository(): PlaylistRepository{
        self::bootKernel();
        $repository = self::getContainer()->get(PlaylistRepository::class);
        return $repository;
    }


    // Définition du nom et titre de la playlist afin de etster l'ajout

    public function newPlaylist(): Playlist {
        $playlist = (new Playlist())
                   ->setName("Titre de la playlist")
                   ->setDescription("Description de la playlist");
        return $playlist;
    }

    // Test ajout playlist

    public function testAddPlaylist() {
        $repository = $this->recupRepository();
        $playlist = $this->newPlaylist();
        $nbPlaylist = $repository->count([]);
        $repository->add($playlist, true);
        $this->assertEquals($nbPlaylist + 1, $repository->count([]), "Erreur lors de l'ajout de la playlist");
    }

    // Test supression Playlist

    public function testRemovePlaylist() {
        $repository = $this->recupRepository();
        $playlist = $this->newPlaylist();
        $repository->add($playlist, true);
        $nbPlaylist = $repository->count([]);
        $repository->remove($playlist, true);
        $this->assertEquals($nbPlaylist - 1, $repository->count([]), "Erreur lors de la suppression de la playlist");
    }

    public function testFindByContainValue() {
        $repository = $this->recupRepository();
        
        
        $valueToSearch = "Bases de la programmation (C#)"; 
        $results = $repository->findByContainValue("name", $valueToSearch);

        $this->assertGreaterThan(0, count($results), "Retourne au moins 1 resultat");

        $this->assertStringContainsString($valueToSearch, $results[0]->getName(), "Le premier résultat doit contenir la valeur recherchée");

    }

}