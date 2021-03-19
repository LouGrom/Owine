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
            'country' => 'France',
            'street' => '69B rue du Colombier',
            'zipCode' => '45000',
            'city' => 'Orléans',
            'province' => '',
            'firstname' => 'Marjolaine',
            'lastname' => 'LETEURTRE',
            'phoneNumber' => '0980802020',
            'iso' => 'FR',
        ];

        $model = new Address();
        // $formData will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(AddressType::class, $model);

        $expected = new Address();
        // ...populate $object properties with the data stored in $formData

        // submit the data to the form directly
        $form->submit($formData);

        // This check ensures there are no transformation failures
        $this->assertTrue($form->isSynchronized());

        // check that $formData was modified as expected when the form was submitted
        $this->assertEquals($expected, $model);
    }
}
