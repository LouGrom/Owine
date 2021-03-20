<?php

namespace App\Tests\Controller;

use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// TODO
class ProductTest extends WebTestCase
{

    use FixturesTrait;

    public function testProductAdd()
    {
        // j'ajoute les classes que les fixtures qu'implémente FixturesTrait
        $this->loadFixtures([
            AppellationFixtures::class,
            ColorFixtures::class,
            ProductCategoryFixtures::class,
            OrderProductFixtures::class,
            CompanyFixtures::class,
        ]);

        // $client = $this->makeClient();
        $client = static::createClient();
        $client->request('GET', '/board/product/new');
        $client->submitForm('Submit product', [
            'appellation' => '',
            'area' => 'Loire',
            'type' => '',
            'cuveeDomaine' => 'Le château de mon père',
            'capacity' => '750',
            'vintage' => '2016',
            'color' => '',
            'alcoholVolume' => '12',
            'price' => '13,5',
            'hsCode' => '2204.21.00',
            'description' => 'La description de mon Chinon',
            'seller' => '',
            'picture' => '',
            'status' => '1',
            'stockQuantity' => '2000',
            'brand' => '',
            'rate' => '',
            'company' => '',
            'createdAt' => '',
            'updatedAt' => '',
        ]);

        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertSelectorExists('div:contains("Le produit a bien été ajouté")');
    }
}