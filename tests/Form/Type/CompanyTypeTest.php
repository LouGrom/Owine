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
        $form = $this->factory->create(CompanyType::class, $model);
        $expected = new Company();
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expected, $model);
    }
}
