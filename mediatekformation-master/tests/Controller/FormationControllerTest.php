<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FormationControllerTest extends WebTestCase
{

    private const FORMATIONS = '/formations';

    // Test d'accès à la page
    public function testAccessPageFormations() {
        $client = static::createClient();
        $client->request('GET', self::FORMATIONS);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

   

    // Filtre par titre de formation
    public function testFiltreFormations()
    {
        $client = static::createClient();
        $client->request('GET',self::FORMATIONS);
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'Java'
        ]);
        $this->assertSelectorTextContains('h5', 'TP Android n°5 : code du controleur et JavaDoc');
        $this->assertCount(7, $crawler->filter('h5'));
    }

    // Filtre par playlist
    public function testFiltrePlaylists()
    {
        $client = static::createClient();
        $client->request('GET',self::FORMATIONS);
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'MCD'
        ]);
        $this->assertSelectorTextContains('h5', 'MCD exercice 18 : sujet 2006 (cas Credauto)');
        $this->assertCount(31, $crawler->filter('h5'));
    }

    // clic sur un lien
    public function testLien()
    {
        $client = static::createClient();
        $client->request('GET',self::FORMATIONS);
        $client->clickLink("image");
        $response = $client->getResponse();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK, $response->getStatusCode());
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        $this->assertEquals(self::FORMATIONS.'/formation/1', $uri);
        $this->assertSelectorTextContains('h4', 'Eclipse n°8 : Déploiement');
    }

}