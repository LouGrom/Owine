<?php

namespace App\Controller\Admin\CrudController;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use App\Admin\Filter\CompanyToValidateFilter;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class HomeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Company::class;
    }

    // public function configureActions(Actions $actions): Actions
    // {
    //     $compapnyToValidate = Action::new('compapnyToValidate', 'fas fa-file-invoice')
    //         ->displayIf(static function ($entity) {
    //             return $entity->getValidated() == 0;
    //         });

    //         // in PHP 7.4 and newer you can use arrow functions
    //         // ->displayIf(fn ($entity) => $entity->isPublished())

    //     return $actions
    //         // ...
    //         ->add(Crud::PAGE_INDEX, $compapnyToValidate);
    // }

    // public function configureCrud(Crud $crud): Crud
    // {
    //     return $crud
    //         ->setSearchFields(['']);

    // }

    


    // public function configureFields(string $pageName): iterable
    // {
    //     return [

    //         IntegerField::new('id')
    //         ->formatValue(function ($value, $entity) {
    //             return $entity->getValidated() === 0 ? $value : "";
    //         })

    //     ];
    // }

    // public function someMethod(AdminContext $context)
    // {
    //     $context = "azazazazazazzaazaazza000000";
    // }

    public function configureResponseParameters(KeyValueStore $responseParameters): KeyValueStore
    {
        
        // $responseParameters->set('_________________foo___________________', '____________test____________');
        // $test = array($responseParameters->get("entities"));
        // dump($test['0']);
        return $responseParameters;
    }
}


