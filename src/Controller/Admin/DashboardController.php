<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Color;
use App\Entity\Order;
use App\Entity\Company;
use App\Entity\Product;
use App\Entity\Broadcast;
use App\Entity\ProductBrand;
use App\Entity\ProductCategory;
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
            // Point de menu pour revenir sur la page d'accueil du dashboard
            MenuItem::linktoDashboard('Home','fa fa-home'),
            
            
            // Point de menu concernant les Users
            // Matérialise une section, utilité: oragnisation visuelle
            MenuItem::section('Users', 'fa fa-users'),

            MenuItem::linkToCrud('All Users', '' , User::class)
            ->setAction('index'),
            MenuItem::linkToCrud('Buyers', '' , User::class),
            MenuItem::linkToCrud('Sellers', '', Company::class),

            MenuItem::subMenu('Actions')->setSubItems([
            
            MenuItem::linkToCrud('Detail User', '' , User::class)
            ->setAction('detail'),
            MenuItem::linkToCrud('Edit User', '' , User::class)
            ->setAction('edit'),
            MenuItem::linkToCrud('Delete User', '' , User::class)
            ->setAction('delete'),
            MenuItem::linkToCrud('Add User', '' , User::class)
            ->setAction('new'),
            ]),   
            
            // // points menu concernant les Products
            // MenuItem::section('Product', 'fa fa-glass'),

            // MenuItem::linkToCrud('All Products', '' , Product::class),

            // MenuItem::subMenu('Actions')->setSubItems([
            
            //     MenuItem::linkToCrud('Detail Product', '' , Product::class)
            //     ->setAction('detail'),
            //     MenuItem::linkToCrud('Edit Product', '' , Product::class)
            //     ->setAction('edit'),
            //     MenuItem::linkToCrud('Delete Product', '' , Product::class)
            //     ->setAction('delete'),
            //     MenuItem::linkToCrud('Add Product', '' , Product::class)
            //     ->setAction('new'),
            //     ]), 
            
        


            // // points menu concernant les Product Categories
            // MenuItem::section('Category', 'fa fa-tags'),

            // MenuItem::linkToCrud('All Categories', '', ProductCategory::class),
           
            // MenuItem::subMenu('Actions')->setSubItems([
            
            //     MenuItem::linkToCrud('Detail Category', '' , ProductCategory::class)
            //     ->setAction('detail'),
            //     MenuItem::linkToCrud('Edit Category', '' , ProductCategory::class)
            //     ->setAction('edit'),
            //     MenuItem::linkToCrud('Delete Category', '' , ProductCategory::class)
            //     ->setAction('delete'),
            //     MenuItem::linkToCrud('Add Category', '' , ProductCategory::class)
            //     ->setAction('new'),
            //     ]), 
           
            // // points menu concernant les Product Colors
            // MenuItem::section('Color Product', 'fa fa-tint'),

            // MenuItem::linkToCrud('All Colors', '', Color::class),
           
            // MenuItem::subMenu('Actions')->setSubItems([
            
            //     MenuItem::linkToCrud('Detail Color', '' , Color::class)
            //     ->setAction('detail'),
            //     MenuItem::linkToCrud('Edit Color', '' , Color::class)
            //     ->setAction('edit'),
            //     MenuItem::linkToCrud('Delete Color', '' , Color::class)
            //     ->setAction('delete'),
            //     MenuItem::linkToCrud('Add Color', '' , Color::class)
            //     ->setAction('new'),
            //     ]), 
            
            // // points menu concernant les Orders 
            // MenuItem::section('Order', 'fa fa-handshake-o'),

            // MenuItem::linkToCrud('All Orders', '', Order::class),
           
            // MenuItem::subMenu('Actions')->setSubItems([
            
            //     MenuItem::linkToCrud('Detail Order', '' , Order::class)
            //     ->setAction('detail'),
            //     MenuItem::linkToCrud('Edit Order', '' , Order::class)
            //     ->setAction('edit'),
            //     MenuItem::linkToCrud('Delete Order', '' , Order::class)
            //     ->setAction('delete'),
            //     MenuItem::linkToCrud('Add Order', '' , Order::class)
            //     ->setAction('new'),
            //     ]),

          

            // // points menu concernant les Colors Product
            // MenuItem::section('Color Product', 'fa fa-tint'),

            // MenuItem::linkToCrud('All Colors', '', Color::class),
           
            // MenuItem::subMenu('Actions')->setSubItems([
            
            //     MenuItem::linkToCrud('Detail Color', '' , Color::class)
            //     ->setAction('detail'),
            //     MenuItem::linkToCrud('Edit Color', '' , Color::class)
            //     ->setAction('edit'),
            //     MenuItem::linkToCrud('Delete Color', '' , Color::class)
            //     ->setAction('delete'),
            //     MenuItem::linkToCrud('Add Color', '' , Color::class)
            //     ->setAction('new'),
            //     ]),

            // // points menu concernant les Colors Product
            // MenuItem::section('Color Product', 'fa fa-tint'),

            // MenuItem::linkToCrud('All Colors', '', Color::class),
           
            // MenuItem::subMenu('Actions')->setSubItems([
            
            //     MenuItem::linkToCrud('Detail Color', '' , Color::class)
            //     ->setAction('detail'),
            //     MenuItem::linkToCrud('Edit Color', '' , Color::class)
            //     ->setAction('edit'),
            //     MenuItem::linkToCrud('Delete Color', '' , Color::class)
            //     ->setAction('delete'),
            //     MenuItem::linkToCrud('Add Color', '' , Color::class)
            //     ->setAction('new'),
            //     ]),

                       
            // point de menu pour la deconnexion
            MenuItem::section('', ''),
            MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
            
           
        ];

    }
}
