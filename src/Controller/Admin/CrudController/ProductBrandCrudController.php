<?php

namespace App\Controller\Admin\CrudController;

use App\Entity\ProductBrand;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductBrandCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductBrand::class;
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
