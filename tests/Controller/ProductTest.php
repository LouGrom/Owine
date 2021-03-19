<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// https://symfony.com/doc/current/testing.html#testing-against-different-sets-of-data
// https://phpunit.de/manual/6.5/en/writing-tests-for-phpunit.html#writing-tests-for-phpunit.data-providers
class ProductTest extends WebTestCase
{
    /**
     * @dataProvider provideUrls
     */
    public function testProductAdd($url)
    {
        $client = static::createClient();
        $client->request('GET', $url);

        $client->submitForm('Save', [
            'appellation' => 'Chinon',
            'area' => 'Loire',
            'type' => 'Vin tranquille',
            'cuveeDomaine' => 'Le château de mon père',
            'capacity' => '750',
            'vintage' => '2016',
            'color' => 'rouge',
            'alcoholVolume' => '12',
            'price' => '13,5',
            'hsCode' => '2204.21.00',
            'description' => 'La description de mon Chinon',
            'picture' => 'photo.jpg',
            'status' => '1',
            'stockQuantity' => '2000',
            'brand' => 'Couly-Dutheil',
        ]);
    
        $this->assertFormValue('#form', 'trialPeriod', '7');
    }

    public function provideUrls()
    {
        return [
            ['/board/product/new'],
            ['/board/product/{id}/edit'],
            // ...
        ];
    }

    
}
