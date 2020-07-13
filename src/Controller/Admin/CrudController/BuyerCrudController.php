<?php

namespace App\Controller\Admin\CrudController;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;




class BuyerCrudController extends AbstractCrudController
{
    


    public static function getEntityFqcn(): string
    {
        return User::class;

    }

    
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
        ->add('roles')
    ;
    }


    // public function configureCrud(Crud $crud): Crud
    // {
     
    // }

    public function configureFields(string $pageName): iterable
    {
        return [

            ArrayField::new('roles')
            // ...but callables also receives the entire entity instance as the second argument
            ->formatValue(function ($value) 
            {
                // dump($value->toString());
                return $value->toString() == 'ROLE_USER, ROLE_BUYER' ? $value : "";
            })

        ];
    }



}
