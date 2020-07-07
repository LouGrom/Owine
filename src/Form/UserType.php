<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('role')
            ->add('companyName')
            ->add('firstname')
            ->add('lastname')
            ->add('email')
            ->add('password')
            ->add('address')
            ->add('zipCode')
            ->add('city')
            ->add('country')
            ->add('phoneNumber')
            ->add('siretNumber')
            ->add('vatNumber')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('receivedOrders')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
