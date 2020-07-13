<?php

namespace App\Controller\Admin\CrudController;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function findAllByUser($validate)
    {
        $builder = $this->createQueryBuilder('sellers');

        $builder->where("cart.user = :userId");

        $builder->setParameter("userId", $id);

        $query = $builder->getQuery();

        return $query->getResult();
}
}
