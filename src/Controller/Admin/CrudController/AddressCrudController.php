<?php

namespace App\Controller\Admin\CrudController;

use App\Entity\Address;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AddressCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Address::class;
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

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            Field::new('firstname'),
            Field::new('lastname'),
            TextField::new('street'),
            IntegerField::new('zipCode'),
            Field::new('city'),
            Field::new('province')->hideOnIndex(),
            Field::new('country'),
            Field::new('phoneNumber')->hideOnIndex(),
            ArrayField::new('type')->hideOnIndex()
            
        ];
    }
    
}
