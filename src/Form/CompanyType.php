<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'entreprise',
                'attr' => [
                    'placeholder' => 'Tabarnak & fils'
                ],
                ])
            ->add('siret', TextType::class, [
                'label' => 'SIRET',
                'attr' => [
                    'placeholder' => 'Votre numéro de SIRET'
                ],
                ])
            ->add('vat', TextType::class, [
                'label' => 'TVA',
                'attr' => [
                    'placeholder' => 'Votre numéro de TVA'
                ],
                ])
            ->add('presentation', TextareaType::class, [
                'label' => 'Présentation',
                'attr' => [
                    'placeholder' => 'Présentez ici votre CAVEAU'
                ],
                ])
            ->add('picture', FileType::class, [
                'label' => 'Image d\'illustration',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
