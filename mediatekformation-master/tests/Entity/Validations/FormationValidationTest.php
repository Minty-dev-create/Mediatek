<?php
namespace App\Tests\Validations;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Formation;
use DateTime;
use Symfony\Component\Validator\Validator\ValidatorInterface;

//Ne pas oublier de maj le validator qui peut etre la source de quelque bugs ! 

class FormationValidationTest extends KernelTestCase
{
    private ValidatorInterface $validator;
    

    protected function setUp(): void
    {
        self::bootKernel();
        $this->validator = self::$container->get(ValidatorInterface::class);
    }

    public function testFormationDateErreur(): void
    {
        $formation = new Formation();
        $formation->setTitle("Titre Formation")
                  ->setPublishedAt(new DateTime("2024-10-7")); // Date future

        $errors = $this->validator->validate($formation);
        $this->assertNotEmpty($errors, "Erreur, la date est postérieure à aujourd'hui");
    }

    public function testFormationDateRéussite(): void
    {
        $formation = new Formation();
        $formation->setTitle("Titre Formation")
                  ->setPublishedAt(new DateTime("2020-10-2")); // Date passée

        $errors = $this->validator->validate($formation);
        $this->assertEmpty($errors, "Réussite, la date est antérieure à aujourd'hui");
    }
}
