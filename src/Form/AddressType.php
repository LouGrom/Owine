<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('country', CountryType::class,[
                'label' => 'Pays',
                'attr' => [
                    'placeholder' => 'France'
                ],
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Fabio'
                ],
                ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom de famille',
                'attr' => [
                    'placeholder' => 'Fabigeonnade'
                ],
                ])
            ->add('street', TextType::class,[
                'label' => 'Adresse postale',
                'attr' => [
                    'placeholder' => '1 boulevard du Shiba'
                ],
            ])
            ->add('zipCode', TextType::class,[
                'label' => 'Code postal',
                'attr' => [
                    'placeholder' => '75009'
                ],
            ])
            ->add('city', TextType::class,[
                'label' => 'Ville',
                'attr' => [
                    'placeholder' => 'Paris'
                ],
            ])
            ->add('phoneNumber', TelType::class,[
                'label' => 'Numéro de téléphone',
                'attr' => [
                    'placeholder' => '0102030405'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
