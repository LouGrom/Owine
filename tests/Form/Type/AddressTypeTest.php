<?php

namespace App\Tests\Form\Type;

use App\Entity\Address;
use App\Form\AddressType;
use Symfony\Component\Form\Test\TypeTestCase;

class AddressTypeTest extends TypeTestCase
{
    public function testAddressType()
    {
        $formData = [
            [
                'country' => 'France',
                'street' => '69B rue du Colombier',
                'zipCode' => '45000',
                'city' => 'Orléans',
                'province' => '',
                'firstname' => 'Marjolaine',
                'lastname' => 'LETEURTRE',
                'phoneNumber' => '0980802020',
                'iso' => 'FR'
            ]
        ];

        $model = new Address();
        $form = $this->factory->create(AddressType::class, $model);
        $expected = new Address();
        $form->submit($formData);

        $this->assertTrue($form->isValid());
        $this->assertEquals($expected, $model);
    }
}
