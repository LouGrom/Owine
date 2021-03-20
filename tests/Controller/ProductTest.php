<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductTest extends WebTestCase
{
    public function testProductAdd()
    {
        $client = static::createClient();
        $client->request('GET', '/board/product/new');
        $client->submitForm('Submit', [
            'product_form[appellation]' => 'Chinon',
            'product_form[area]' => 'Loire',
            'product_form[type]' => 'Tranquille',
            'product_form[cuveeDomaine]' => 'La cuvée de Lou',
            'product_form[capacity]' => '750',
            'product_form[vintage]' => '2016',
            'product_form[color]' => 'Loire',
            'product_form[alcoholVolume]' => '12',
            'product_form[price]' => '13,5',
            'product_form[hsCode]' => '2204.21.00',
            'product_form[description]' => 'La description de mon Chinon',
            'product_form[picture]' => '',
            'product_form[status]' => '1',
            'product_form[stockQuantity]' => '25000',
            'product_form[brand]' => 'La marque de Nico',
            'product_form[rate]' => '5',
            'product_form[company]' => 'La Lou Company',
            'product_form[createdAt]' => '',
            'product_form[updatedAt]' => '',
        ]);

        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertSelectorExists('div:contains("Le produit a bien été ajouté")');
    }
}
