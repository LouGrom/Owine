<?php

namespace App\Controller\Admin;

use App\Entity\Type;
use App\Entity\User;
use App\Entity\Color;
use App\Entity\Order;
use App\Entity\Company;
use App\Entity\Product;
use App\Entity\OrderProduct;
use App\Entity\ProductBrand;
use App\Entity\ProductCategory;
use App\Repository\UserRepository;
use App\Repository\CompanyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use App\Controller\Admin\CrudController\HomeCrudController;
use App\Controller\Admin\CrudController\BuyerCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use App\Controller\Admin\CrudController\CompanyCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\DependencyInjection\ContainerBuilder;




class DashboardController extends AbstractDashboardController
{
    private $company;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->company = $companyRepository->findAll();
        dump($this->company);
    }
    /**
     * @Route("/admin", name="admin", methods={"GET"})
     */
     public function index(): Response
    {
        
        // $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
        // return $this->redirect($routeBuilder->setController(HomeCrudController::class)->generateUrl()); 
        return $this->render('admin/dashboard.html.twig', [
            'companies' => $this->company
        ]);
    }
    
    // public function configureResponseParameters(KeyValueStore $responseParameters): KeyValueStore
    // {
        
    //     $responseParameters->set('_________________foo___________________', CompanyRepository::findAll());
    //     dd($responseParameters);
     
    //     return $responseParameters;
    // }


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
            
            MenuItem::linkToCrud('User', 'fa fa-users', User::class),
           
            MenuItem::linkToCrud('Buyers', '' , User::class)
            ->setController(BuyerCrudController::class),
            

            // MenuItem::subMenu('Actions')->setSubItems([
            
            // MenuItem::linkToCrud('Detail User', 'fa fa-search-plus' , User::class)
            // ->setAction('detail'),
            // MenuItem::linkToCrud('Edit User', 'fa fa-pencil-square-o' , User::class)
            // ->setAction('edit'),
            // MenuItem::linkToCrud('Delete User', 'fa fa-trash' , User::class)
            // ->setAction('delete'),
            // MenuItem::linkToCrud('Add User', 'fa fa-plus-circle' , User::class)
            // ->setAction('new'),
            // ]),  

            // Point de menu concernant les Companies
            
            MenuItem::linkToCrud('Company', 'fa fa-building', Company::class)
            ->setController(CompanyCrudController::class),
            

            // MenuItem::subMenu('Actions')->setSubItems([
            
            // MenuItem::linkToCrud('Detail Company', 'fa fa-search-plus' , Company::class)
            // ->setAction('detail'),
            // MenuItem::linkToCrud('Edit Company', 'fa fa-pencil-square-o' , Company::class)
            // ->setAction('edit'),
            // MenuItem::linkToCrud('Delete Company', 'fa fa-trash' , Company::class)
            // ->setAction('delete'),
            // MenuItem::linkToCrud('Add Company', 'fa fa-plus-circle' , Company::class)
            // ->setAction('new'),
            // ]),
            
            // Point de menu concernant les Orders 
            MenuItem::linkToCrud('Order', 'fa fa-handshake-o', Order::class),
           
            // MenuItem::subMenu('Actions')->setSubItems([
            
            //     MenuItem::linkToCrud('Detail Order', 'fa fa-search-plus' , Order::class)
            //     ->setAction('detail'),
            //     MenuItem::linkToCrud('Edit Order', 'fa fa-pencil-square-o' , Order::class)
            //     ->setAction('edit'),
            //     MenuItem::linkToCrud('Delete Order', 'fa fa-trash' , Order::class)
            //     ->setAction('delete'),
            //     MenuItem::linkToCrud('Add Order', 'fa fa-plus-circle' , Order::class)
            //     ->setAction('new'),
            //     ]),

            // Point de menu concernant les Orders with Product List
            MenuItem::linkToCrud('Order with Product List', 'fa fa-list-alt', OrderProduct::class),
           
           
            // MenuItem::subMenu('Actions')->setSubItems([
            
            //     MenuItem::linkToCrud('Detail Orders With Product List', 'fa fa-search-plus' , OrderProduct::class)
            //     ->setAction('detail'),
            //     MenuItem::linkToCrud('Edit Orders With Product List', 'fa fa-pencil-square-o' , OrderProduct::class)
            //     ->setAction('edit'),
            //     MenuItem::linkToCrud('Delete Orders With Product List', 'fa fa-trash' , OrderProduct::class)
            //     ->setAction('delete'),
            //     MenuItem::linkToCrud('Add Orders With Product List', 'fa fa-plus-circle' , OrderProduct::class)
            //     ->setAction('new'),
            //     ]),
            
            // Point de menu concernant les Products
            MenuItem::linkToCrud('Product', 'fa fa-glass', Product::class),

            // MenuItem::subMenu('Actions')->setSubItems([
            
            //     MenuItem::linkToCrud('Detail Product', 'fa fa-search-plus' , Product::class)
            //     ->setAction('detail'),
            //     MenuItem::linkToCrud('Edit Product', 'fa fa-pencil-square-o' , Product::class)
            //     ->setAction('edit'),
            //     MenuItem::linkToCrud('Delete Product', 'fa fa-trash' , Product::class)
            //     ->setAction('delete'),
            //     MenuItem::linkToCrud('Add Product', 'fa fa-plus-circle' , Product::class)
            //     ->setAction('new'),
            //     ]), 
            
            // Point de menu concernant les Product brands
            MenuItem::linkToCrud('Brand', 'fa fa-circle', ProductBrand::class),
           
            // MenuItem::subMenu('Actions')->setSubItems([
            
            //     MenuItem::linkToCrud('Detail Brand', 'fa fa-search-plus' , ProductBrand::class)
            //     ->setAction('detail'),
            //     MenuItem::linkToCrud('Edit Brand', 'fa fa-pencil-square-o' , ProductBrand::class)
            //     ->setAction('edit'),
            //     MenuItem::linkToCrud('Delete Brand', 'fa fa-trash' , ProductBrand::class)
            //     ->setAction('delete'),
            //     MenuItem::linkToCrud('Add Brand', 'fa fa-plus-circle' , ProductBrand::class)
            //     ->setAction('new'),
            //     ]),

            // Point de menu concernant les Product Categories
            MenuItem::linkToCrud('Category', 'fa fa-tags', ProductCategory::class),
           
            // MenuItem::subMenu('Actions')->setSubItems([
            
            //     MenuItem::linkToCrud('Detail Category', 'fa fa-search-plus' , ProductCategory::class)
            //     ->setAction('detail'),
            //     MenuItem::linkToCrud('Edit Category', 'fa fa-pencil-square-o' , ProductCategory::class)
            //     ->setAction('edit'),
            //     MenuItem::linkToCrud('Delete Category', 'fa fa-trash' , ProductCategory::class)
            //     ->setAction('delete'),
            //     MenuItem::linkToCrud('Add Category', 'fa fa-plus-circle' , ProductCategory::class)
            //     ->setAction('new'),
            //     ]), 

            // Point de menu concernant les Product Types
            MenuItem::linkToCrud('Type', 'fa fa-th-large', Type::class),
           
            // MenuItem::subMenu('Actions')->setSubItems([
            
            //     MenuItem::linkToCrud('Detail Type', 'fa fa-search-plus' , Type::class)
            //     ->setAction('detail'),
            //     MenuItem::linkToCrud('Edit Type', 'fa fa-pencil-square-o' , Type::class)
            //     ->setAction('edit'),
            //     MenuItem::linkToCrud('Delete Type', 'fa fa-trash' , Type::class)
            //     ->setAction('delete'),
            //     MenuItem::linkToCrud('Add Type', 'fa fa-plus-circle' , Type::class)
            //     ->setAction('new'),
            //     ]),

           
            // Point de menu concernant les Product Colors
            MenuItem::linkToCrud('Color', 'fa fa-tint', Color::class),
           
            // MenuItem::subMenu('Actions')->setSubItems([
            
            //     MenuItem::linkToCrud('Detail Color', 'fa fa-search-plus' , Color::class)
            //     ->setAction('detail'),
            //     MenuItem::linkToCrud('Edit Color', 'fa fa-pencil-square-o' , Color::class)
            //     ->setAction('edit'),
            //     MenuItem::linkToCrud('Delete Color', 'fa fa-trash' , Color::class)
            //     ->setAction('delete'),
            //     MenuItem::linkToCrud('Add Color', 'fa fa-plus-circle' , Color::class)
            //     ->setAction('new'),
            //     ]),             

                       
            // point de menu pour la deconnexion
           
            MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
            
           
        ];

    }
}
