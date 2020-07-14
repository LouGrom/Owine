<?php

namespace App\Controller\Admin\CrudController;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;




class UserCrudController extends AbstractCrudController
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

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            // ...
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            
        ;
    }


    // public function configureCrud(Crud $crud): Crud
    // {
     
    // }

    public function configureFields(string $pageName): iterable
    {
        
        return [
            Field::new('id')->hideOnForm(),
            Field::new('email'),
            Field::new('firstname'),
            Field::new('lastname'),
            Field::new('address')->hideOnIndex(),
            Field::new('zipCode')->hideOnIndex(),
            Field::new('city')->hideOnIndex(),
            Field::new('country')->hideOnIndex(),
            Field::new('phoneNumber')->hideOnIndex()

                       
        ];
    
        
    }



}
