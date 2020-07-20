<?php

namespace App\Controller\Admin;

use App\Entity\Package;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PackageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Package::class;
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
