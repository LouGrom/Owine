<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Address;
use App\Form\AddressType;
use App\Form\CompanyType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        // ->add(
        //     'roles', ChoiceType::class, [
        //         'label' => 'Vous êtes :',
        //         'choices' => ['Un particulier' => 'ROLE_BUYER', 'Pas particulier' => 'ROLE_SELLER'],
        //         'expanded' => true,
        //         'multiple' => true,
        //     ]
        // )
        
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
        ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'Les deux mots de passe doivent correspondre',
            'options' => ['attr' => ['class' => 'password-field']],
            'required' => true,
            'first_options'  => ['label' => 'Mot de passe'],
            'second_options' => ['label' => 'Répétez votre mot de passe'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
