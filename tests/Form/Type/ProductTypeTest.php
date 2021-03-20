<?php

namespace App\Tests\Form\Type;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Component\Form\Test\TypeTestCase;

class ProductTypeTest extends TypeTestCase
{
    public function testProductType()
    {
        $formData = [
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
        ];

        
        $model = new Product();
        // $formData will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(ProductType::class, $model);

        $expected = new Product();
        // ...populate $object properties with the data stored in $formData

        // submit the data to the form directly
        $form->submit($formData);

        dd($form);
        // This check ensures there are no transformation failures
        $this->assertTrue($form->isSynchronized());

        // check that $formData was modified as expected when the form was submitted
        $this->assertEquals($expected, $model);
    }
}
