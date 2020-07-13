<?php

namespace App\Controller\Admin\CrudController;

use App\Entity\OrderProduct;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OrderProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OrderProduct::class;
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
