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
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action->setIcon('fa fa-search')->setLabel(false);
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setIcon('fa fa-edit')->setLabel(false);
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->setIcon('fa fa-trash-alt')->setLabel(false);
            }) ;
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
