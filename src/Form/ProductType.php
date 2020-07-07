<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\ProductBrand;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $typeChoice=['Cuit' => 'cuit', 'Effervescent'=> 'effervescent', 'Tranquille' => 'tranquille', 'Crémeux' => 'cremeux'];
        $colorChoice=['Rouge'=> 'rouge', 'Blanc' => 'blanc', 'Rosé' => 'rose', 'Blouge' => 'blouge', 'F0F' => '#ff00ff'];
        $builder
            ->add('appellation', TextType::class, ["label"=>"Nom du produit"])
            ->add('area', TextType::class, ["label"=>"Zone"])
            ->add('type', ChoiceType::class, ['choices'=>[$typeChoice]])
            ->add('cuveeDomaine', TextType::class, ["label"=>"Cuvée Domaine"])
            ->add('capacity',)
            ->add('vintage')
            ->add('color', ChoiceType::class, ['choices'=>[$colorChoice]])
            ->add('alcoholVolume')
            ->add('price')
            ->add('hsCode', TextType::class, ["label"=>"Code barre"])
            ->add('description', TextareaType::class, ["label"=>"Description"])
            ->add('picture')
            ->add('status')
            ->add('stockQuantity')
            // ->add('createdAt')
            // ->add('updatedAt')
            // ->add('seller')
            ->add('brand', EntityType::class, [
                "label" => "Marque",
                "class" => ProductBrand::class,
                "choice_label" => 'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
