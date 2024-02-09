<?php

namespace App\Tests\Repository;


use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CategorieRepositoryTest extends KernelTestCase
{
    public function recupRepository(): CategorieRepository{
        self::bootKernel();
        $repository = self::getContainer()->get(CategorieRepository::class);
        return $repository;
    }
   
    
    public function newCategorie(): Categorie {
        $categorie = (new Categorie())
                   ->setName("Nom de la catégorie");
        return $categorie;
    }

    public function testajoutCategorie() {
        $repository = $this->recupRepository();
        $categorie = $this->newCategorie();
        $nbCategories = $repository->count([]);
        $repository->add($categorie, true);
        $this->assertEquals($nbCategories + 1, $repository->count([]), "Erreur lors de l'ajout de la catégorie");
    }
    public function testSupprCategorie() {
        $repository = $this->recupRepository();
        $categorie = $this->newCategorie();
        $repository->add($categorie, true);
        $nbCategories = $repository->count([]);
        $repository->remove($categorie, true);
        $this->assertEquals($nbCategories - 1, $repository->count([]), "Erreur lors de la suppression de la catégorie");
    }
  
    public function testFindByContainValue() {
        $repository = $this->recupRepository();
        
        
        $valueToSearch = "Bases de la programmation (C#)"; 
        $results = $repository->findByContainValue("title", $valueToSearch);

        $this->assertGreaterThan(0, count($results), "Retourne au moins 1 resultat");

        $this->assertStringContainsString($valueToSearch, $results[0]->getTitle(), "Le premier résultat doit contenir la valeur recherchée");

    }

}