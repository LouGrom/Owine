<?php

namespace App\Controller\Admin\CrudController;


use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use App\Controller\Admin\CrudController\HomeCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;




class BuyerCrudController extends AbstractCrudController
{
    // private $users;

    // public function __construct(UserRepository $userRepository)
    // {
    //     $this->users = $userRepository->findBy(['roles'=> 'ROLE_USER, ROLE_BUYER']);
        
    // }

    public static function getEntityFqcn(): string
    {
        return User::class;

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
            Field::new('id')->hideOnForm(),
            Field::new('email'),
            Field::new('firstname'),
            Field::new('lastname'),
            ArrayField::new('roles'),// ->formatValue(function ($value),
            // {
            //     // dump($value->toString());
            //     return $value->toString() == 'ROLE_USER, ROLE_BUYER' ? $value : "";
            // }),
            Field::new('address')->hideOnIndex(),
            Field::new('zipCode')->hideOnIndex(),
            Field::new('city')->hideOnIndex(),
            Field::new('country')->hideOnIndex(),
            Field::new('phoneNumber')->hideOnIndex()
                       
        ];
    
    }

    // public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    // {
    //     $test = '["ROLE_USER", "ROLE_BUYER"]';
    //     //dd($response = $this->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters),  $response = $this->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters)->where('entity.roles'->LIKE('%BUYER%')));
    //     $response = $this->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters)->andWhere('entity.roles = ROLE_USER, ROLE_BUYER');
    //     dump($response, 'entity.roles');
    //     return $response;
 
    // }

}
