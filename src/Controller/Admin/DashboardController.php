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
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use App\Controller\Admin\CrudController\HomeCrudController;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use App\Controller\Admin\CrudController\BuyerCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use App\Controller\Admin\CrudController\SellerCrudController;
use App\Controller\Admin\CrudController\CompanyCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;




class DashboardController extends AbstractDashboardController
{
    private $companies;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companies = $companyRepository;
        
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        
        // $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
        // return $this->redirect($routeBuilder->setController(HomeCrudController::class)->generateUrl()); 
        return $this->render('bundles/EasyAdminBundle/home/content.html.twig', [
            'companies' => $this->companies->findBy(['validated'=>0])
        ]);
    }
    // /**
    //  * @Route("/admin/show/{id}", name="show", requirements={'id'='\d+'})
    //  */
    // public function show($id): Response
    // {
    //     $company =$this->companies->findBy(['id'=>$id])
    //     
    //     return $this->render('bundles/EasyAdminBundle/home/show.html.twig', [
    //         'company' => $company
    //     ]);
    // }
    
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

    // public function configureFilters(Filters $filters): Filters
    // {
    //     return $filters
    //     ->add(BooleanFilter::new('validated'));
    // }

    // public function configureActions(Actions $actions): Actions
    // {
    //     return $actions
    //         // ...
    //         ->add(Crud::PAGE_INDEX, Action::DETAIL)
            
    //     ;
    // }

    public function configureMenuItems(): iterable
    {
        
       
        
        
        return [
            // Point de menu pour revenir sur la page d'accueil du dashboard
            MenuItem::linktoDashboard('Home','fa fa-home'),
            
            
            // Point de menu concernant les Users
            MenuItem::section('User', 'fa fa-users'),
            MenuItem::linkToCrud('All Users', '', User::class),
           
            MenuItem::linkToCrud('Buyers', '' , User::class)
            ->setController(BuyerCrudController::class),

            MenuItem::linkToCrud('Sellers', '' , User::class)
            ->setController(SellerCrudController::class),
            

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
             
            // Point de menu invisible sur le front mais servant a créer un espace
            MenuItem::section('', ''),

            // Point de menu concernant les Companies
            
            MenuItem::linkToCrud('Company', 'fa fa-building', Company::class)
            ->setController(CompanyCrudController::class),
            
            
            // Point de menu concernant les Orders 
            MenuItem::linkToCrud('Order', 'fa fa-handshake-o', Order::class),
           
            // MenuItem::subMenu('Actions')->setSubItems([
            

            // Point de menu concernant les Orders with Product List
            MenuItem::linkToCrud('Order with Product List', 'fa fa-list-alt', OrderProduct::class),
           
            
            // Point de menu concernant les Products
            MenuItem::linkToCrud('Product', 'fa fa-glass', Product::class),

            // MenuItem::subMenu('Actions')->setSubItems([
            
            
            // Point de menu concernant les Product brands
            MenuItem::linkToCrud('Brand', 'fa fa-circle', ProductBrand::class),
           
            // MenuItem::subMenu('Actions')->setSubItems([
            
           
            // Point de menu concernant les Product Categories
            MenuItem::linkToCrud('Category', 'fa fa-tags', ProductCategory::class),
           
            // MenuItem::subMenu('Actions')->setSubItems([
            

            // Point de menu concernant les Product Types
            MenuItem::linkToCrud('Type', 'fa fa-th-large', Type::class),
           
            // MenuItem::subMenu('Actions')->setSubItems([
            
           
            // Point de menu concernant les Product Colors
            MenuItem::linkToCrud('Color', 'fa fa-tint', Color::class),
           
            // MenuItem::subMenu('Actions')->setSubItems([            

                       
            // point de menu pour la deconnexion
           
            MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
            
           
        ];

    }
}
