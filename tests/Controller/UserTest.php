<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{
    public function testAnonymous()
    {
        // on fait une requête vers /admin qui n'est normalement accessible qu'au ROLE_ADMIN
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin');

        // on vérifie que la réponse redirige vers l'url de connexion
        $this->assertResponseRedirects('/login');
    }

    // tester la connexion d'un utilisateur buyer mais à une route qui ne lui est pas accessible
    public function testUserSeller()
    {
        $client = static::createClient();
        // on récupère le repository des utilisateurs
        $userRepository = static::$container->get(UserRepository::class);

        // on récupère l'utilisateur avec le ROLE_BUYER
        $testUser = $userRepository->findOneByEmail('seller@mail.fr');

        // on simule la connexion de l'utilisateur
        $client->loginUser($testUser);

        // on teste une requête sur la page de connexion
        $client->request('GET', '/admin');
        // on vérifie que le code réponse est 403 (Forbidden)
        $this->assertResponseStatusCodeSame(403);
    }
}
