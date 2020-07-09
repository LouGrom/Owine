<?php

namespace App\Form;

use App\Entity\User;
use App\Form\AddressType;
use App\Form\CompanyType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        /*->add(
            'roles', ChoiceType::class, [
                'label' => 'Vous êtes :',
                'choices' => ['Un particulier' => 'ROLE_BUYER', 'Pas particulier' => 'ROLE_SELLER'],
                //'expanded' => true,
                'multiple' => true,
            ]
        )*/
        
        ->add('firstname', TextType::class, [
            'label' => 'Prénom',
            'attr' => [
                'placeholder' => 'Fabio'
            ],
            ])
        ->add('lastname', TextType::class, [
            'label' => 'Nom',
            'attr' => [
                'placeholder' => 'Shiba'
            ],
            ])
        ->add('email', EmailType::class, [
            'label' => 'Adresse mail',
            'attr' => [
                'placeholder' => 'iloveshiba@gmail.com'
            ],
            ])
        ->add('password', PasswordType::class, [
            // instead of being set onto the object directly,
            // this is read and encoded in the controller
            'label' => 'Mot de passe',
            'help' => 'Votre mot de passe doit contenir au moins une majuscule, une minuscule, un chiffres, un caractère spécial et doit faire au moins 8 caractères',
            'attr' => [
                'placeholder' => 'Azerty#123'
            ],
            'mapped' => true,
            ])
        ->add('address', CollectionType::class, [
            'entry_type' => AddressType::class,
            'entry_options' => ['label' => false],
            'allow_add' => true,
        ])
        ->add('company', CompanyType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
