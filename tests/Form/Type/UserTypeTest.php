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
        // $formData will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(UserType::class, $model);

        $expected = new User();
        // ...populate $object properties with the data stored in $formData

        // submit the data to the form directly
        $form->submit($formData);

        // This check ensures there are no transformation failures
        $this->assertTrue($form->isSynchronized());

        // check that $formData was modified as expected when the form was submitted
        $this->assertEquals($expected, $model);
    }
}
