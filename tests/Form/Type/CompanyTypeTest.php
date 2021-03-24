<?php

namespace App\Tests\Form\Type;

use App\Entity\Company;
use App\Form\CompanyType;
use Symfony\Component\Form\Test\TypeTestCase;

class CompanyTypeTest extends TypeTestCase
{
    public function testCompanyType()
    {
        $formData = [
            [
                'name' => 'Milo le Chat',
                'siret' => '905 720 041 00052',
                'vat' => 'FR 15 905720041',
                'picture' => 'https://live.staticflickr.com/7133/7717473276_a1d4c92c13_b.jpg',
                'validated' => 1,
                'presentation' => "Baptême de crisse de cibole de viande à chien, j'en ai plein mon casse d'être toute décalissé de la vie, avec le windshier de mon char toute déviargé par l'autre esti de cave. Quessé tu veux j'te dise sacrament, fouille-moé bout d'viarge, je le sais-tu moé. Ben coudonc, t'es encore là toé ? ",
                'rate' => 5,
                'seller' => [
                    [
                        'firstname' => 'Djyp',
                        'lastname' => 'FOREST FORTIN',
                        'email' => 'seller9@mail.fr',
                        'password' => password_hash("banane", PASSWORD_DEFAULT),
                        'roles' => ['ROLE_SELLER']
                    ]
                ],
                'address' => [
                    [
                        'firstname' => 'Djyp',
                        'lastname' => 'FOREST FORTIN',
                        'street' => '78 Avenue du Québec',
                        'city' => 'Villebon-sur-Yvette',
                        'zipCode' => '91140',
                        'country' => 'France',
                        'iso' => 'FR',
                        'phoneNumber' => '05 45 36 87 00'
                    ]
                ],
                'packages' => [],
                'destinations' => [],
                'products' => [
                    [
                        'appellation' => 'Vin de glace',
                        'price' => 29,90,
                        'description' => "Pour produire le vin de glace, on attend que la température descende en dessous de -8°C. En effet, le raisin doit être récolté gelé puis immédiatement pressé avant d’être mis en fermentation…",
                        'quantity' => 36000,
                        'vintage' => 'Non millésimé',
                        'brand' => 'Le Cep d’Argent',
                        'color' => 'Blanc',
                        'type' => 'Liqueur',
                        'category' => 'AOP',
                        'alcoholVolume' => 40,
                        'picture' => 'https://www.epicerie-quebecoise.com/media/cache/produit_visuel/images/produit/5ceba20cd2c5d335791909.jpg',
                        'hsCode' => '2208.21',
                        'area' => 'Canada',
                        'cuveeDomaine' => 'Milo',
                        'capacity' => 200,
                        'status' => 1,
                        'rate' => 5
                    ],    
                ]   
            ],
        ];

        $model = new Company();
        $form = $this->factory->create(CompanyType::class, $model);
        $expected = new Company();
        $form->submit($formData);

        $this->assertTrue($form->isValid());
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expected, $model);
    }
}
