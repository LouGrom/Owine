<?php

namespace App\Controller\Admin\CrudController;

use App\Entity\OrderProduct;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OrderProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OrderProduct::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            // ...
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            
        ;
    }

    // public function configureFields(string $pageName): iterable
    // {
    //     yield IntegerField::new('id');
    //     yield ArrayField::new('order');
    // }


    
    // public function configureFields(string $pageName): iterable
    // {
    //     return [
    //         'id',
    //         // 'order',
    //         //'product',
    //         'quantity',
    //     ];
    // }
    
}
