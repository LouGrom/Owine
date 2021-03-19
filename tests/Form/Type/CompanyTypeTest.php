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
            'name' => 'MON ENTREPRISE',
            'siret' => '52926125700032',
            'vat' => 'FR95529261257',
            'presentation' => 'La présentation de mon entreprise',
            'seller' => '',
            'picture' => 'https://media-exp1.licdn.com/dms/image/C560BAQGqsRF7CRI_HQ/company-logo_200_200/0/1519892930205?e=2159024400&v=beta&t=qKz-ilEuGmiS-kjNE59CthjTY4UJ41kZEWUuNp72ZRQ',
            'validated' => 1,
            'rate' => 5,
            'destinations' => [
                'FR',
                'IT',
            ],
            'packages' => '',
        ];

        $model = new Company();
        // $formData will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(CompanyType::class, $model);

        $expected = new Company();
        // ...populate $object properties with the data stored in $formData

        // submit the data to the form directly
        $form->submit($formData);

        // This check ensures there are no transformation failures
        $this->assertTrue($form->isSynchronized());

        // check that $formData was modified as expected when the form was submitted
        $this->assertEquals($expected, $model);
    }
}
