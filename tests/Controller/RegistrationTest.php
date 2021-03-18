<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// pour un test fonctionnel, on étend WebTestCase de Symfony et non plus TestCase de PHPUnit
class RegistrationTest extends WebTestCase
{
    public function testRegistrationPage()
    {
        // $client représente le navigateur en objet PHP
        $client = static::createClient();
        // on simule une requête sur la route
        $crawler = $client->request('GET', '/register');

        // on vérifie que la réponse de la requête donne bien un code 200
        // $this->assertResponseIsSuccessful();

        // on certifie qu'on arrive à trouver un élément grâche au selecteur H1
        // $this->assertSelectorTextContains('h1', 'Inscription');

        $this->assertResponseRedirects();
    }
}
