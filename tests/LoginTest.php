<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
     * Ce test nous montre comment mettre en place la vérification du statut de la réponse
     * suite à une requête HTTP. Ici, on vérifie que le statut de la réponse est bien 200.
     * Cependant, cette route étant protégée par un firewall, on doit se connecter avant
     * de se rendre sur cette page. Pour cela, on utilise fait appel au repository user
     * puis on le connecte avec la méthode loginUser() du client HTTP de WebTestCase
     */

class LoginTest extends WebTestCase
{
    // public function testSomething(): void
    // {
    //     $client = static::createClient();
    //     $crawler = $client->request('GET', '/');

    //     $this->assertResponseIsSuccessful();
    //     $this->assertSelectorTextContains('p', 'Paris');
    // }
    public function testAccountRouteWhenLoggedIn(): void
    {
        self::ensureKernelShutdown();
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $admin = $userRepository->findOneBy(['email'=>'admin@admin.fr']);
        $client->loginUser($admin);
        $client->request('GET', '/account');
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorTextContains('h1', $admin->getFullname());
        $this->assertSelectorTextContains('p', $admin->getEmail());
    }
}
