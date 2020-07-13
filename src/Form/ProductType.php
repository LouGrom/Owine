<?php

namespace App\Form;

use App\Entity\Appellation;
use App\Entity\Color;
use App\Entity\User;
use App\Entity\Product;
use App\Entity\ProductBrand;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ProductType extends AbstractType
{
    private $user;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->user = $tokenStorage->getToken()->getUser();
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('appellation', EntityType::class, [
                "label"=>"Nom du produit",
                "class"=>Appellation::class,
                "choice_label"=>'name'
            ])
            ->add('area', TextType::class, ["label"=>"Zone"])
            ->add('type', EntityType::class, [
                'label'=> 'Type de vin',
                'class' => Type::class,
                "choice_label"=>"name"
                ])
            ->add('cuveeDomaine', TextType::class, ["label"=>"Cuvée Domaine"])
            ->add('capacity', NumberType::class, ["label" => "Volume (en mL)"])
            ->add('vintage', IntegerType::class, ["label" => "Date de création"])
            ->add('color', EntityType::class, [
                "label" => "Couleur du vin",
                "class" => Color::class,
                "choice_label" => 'name'
            ])
            ->add('alcoholVolume', NumberType::class, ["label" => "Volume d'alcool (%)"])
            ->add('price', MoneyType::class, [
                "label" => "Prix à l'unité",
                "currency" => "EUR"
            ])
            ->add('hsCode', TextType::class, ["label"=>"Code douanier"])
            ->add('description', TextareaType::class, ["label"=>"Description"])
            ->add('picture')
            ->add('status', ChoiceType::class, [
                "label" => "À vendre immédiatement ?",
                "choices" => [
                    'Oui' => 1,
                    'Non' => 0
                ]
            ])
            ->add('stockQuantity', IntegerType::class, ["label" => "Quantité à vendre"])
            // ->add('createdAt')
            // ->add('updatedAt')
            ->add('seller', ChoiceType::class, [
                "label" => 'Vendeur',
                "choices" => [$this->user->getFirstname() => $this->user]
            ])


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
