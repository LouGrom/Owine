<?php

namespace App\Controller\Admin\CrudController;


use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use App\Controller\Admin\CrudController\HomeCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;




class BuyerCrudController extends AbstractCrudController
{
    private $users;

    public function __construct(UserRepository $userRepository)
    {
        $this->users = $userRepository->findBy(['roles'=> 'ROLE_USER, ROLE_BUYER']);
        
    }

    public static function getEntityFqcn(): string
    {
        return User::class;

    }

    // public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    // {
        
        
    //     dd($this->queryBuilder);
    //     return $queryBuilder;
    // }

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
