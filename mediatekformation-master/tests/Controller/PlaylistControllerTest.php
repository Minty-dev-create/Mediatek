<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlaylistControllerTest extends WebTestCase
{
    private const PLAYLISTS = '/playlists';


    // clic sur le bouton voir détail
    public function testBouton()
    {
        $client = static::createClient();
        $client->request('GET',self::PLAYLISTS);
        $client->clickLink("Voir détail");
        $response = $client->getResponse();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK, $response->getStatusCode());
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        $this->assertEquals(self::PLAYLISTS.'/playlist/13', $uri);
        $this->assertSelectorTextContains('h4', "Bases de la programmation (C#)");
    }
}