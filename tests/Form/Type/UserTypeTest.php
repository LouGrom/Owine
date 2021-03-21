<?php

namespace App\Tests\Form\Type;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Form\Test\TypeTestCase;

class UserTypeTest extends TypeTestCase
{
    public function testUserType()
    {
        $formData = [
            'firstname' => 'Marjolaine',
            'lastname' => 'LETEURTRE',
            'email' => 'marjolaine@mail.fr',
            'password' => 'banane',
            'roles' => 'ROLE_BUYER',
        ];

        $model = new User();
        $form = $this->factory->create(UserType::class, $model);
        $expected = new User();
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expected, $model);
    }
}
