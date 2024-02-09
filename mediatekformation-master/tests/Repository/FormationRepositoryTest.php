<?php

namespace App\Tests\Repository;

use App\Entity\Formation;
use App\Repository\FormationRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FormationRepositoryTest extends KernelTestCase
{
    public function recupRepository(): FormationRepository{
        self::bootKernel();
        $repository = self::getContainer()->get(FormationRepository::class);
        return $repository;
    }


    public function newFormation(): Formation {
        $formation = (new Formation())
                   ->setTitle("Titre de la formation")
                   ->setDescription("Description de la formation")
                   ->setPublishedAt(new DateTime('now'));
        return $formation;
    }

    public function testAjoutFormation() {
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $nbFormations = $repository->count([]);
        $repository->add($formation, true);
        $this->assertEquals($nbFormations + 1, $repository->count([]), "Erreur lors de l'ajout de la formation");
    }

    public function testSupprFormation() {
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $repository->add($formation, true);
        $nbFormations = $repository->count([]);
        $repository->remove($formation, true);
        $this->assertEquals($nbFormations - 1, $repository->count([]), "Erreur lors de la suppression de la catégorie");
    }
    
    
    public function testFindByContainValue() {
        $repository = $this->recupRepository();
        
        
        $valueToSearch = "Eclipse n°8 : Déploiement"; 
        $results = $repository->findByContainValue("title", $valueToSearch);

        $this->assertGreaterThan(0, count($results), "Retourne au moins 1 resultat");
        $this->assertStringContainsString($valueToSearch, $results[0]->getTitle(), "Le premier résultat doit contenir la valeur recherchée");

    }
    
}