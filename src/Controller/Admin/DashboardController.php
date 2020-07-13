<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Company;
use App\Entity\Product;
use App\Entity\Broadcast;
use App\Controller\UserController;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use App\Controller\Admin\CrudController\UserCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin", methods={"GET"})
     */
     public function index(): Response
    {
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
        return $this->redirect($routeBuilder->setController(UserCrudController::class)->generateUrl()); 
    }


    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('O\'Wine admin');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linktoDashboard('Dashboard', 'fa fa-home'),
    
            MenuItem::linkToCrud('Users', 'fa fa-user', User::class),
            MenuItem::linkToCrud('Company', 'fa fa-building', Company::class),
            MenuItem::linkToCrud('Product', 'fa fa-glass', Product::class),

            MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
        ];

    }
}
