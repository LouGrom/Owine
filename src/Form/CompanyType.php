<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de votre société *'
            ])
            ->add('siret', TextType::class, [
                'label' => 'Numéro de SIRET de votre société *'
            ])
            ->add('vat', TextType::class, [
                'label' => 'Numéro de TVA de votre société *'
            ])
            ->add('picture', FileType::class, [
                'label' => 'Logo de votre société ou photo du domaine',
                'required' => false
            ])
            ->add('presentation', TextareaType::class, [
                'label' => 'Enfin, présentez votre entreprise en quelques lignes :'
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
