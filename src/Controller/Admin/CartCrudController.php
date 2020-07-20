<?php

namespace App\Controller\Admin;

use App\Entity\Cart;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CartCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Cart::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
