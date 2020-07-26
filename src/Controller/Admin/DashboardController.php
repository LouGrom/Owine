<?php

namespace App\Controller\Admin;

use App\Controller\Admin\CrudController\BuyerCrudController;
use App\Controller\Admin\CrudController\CompanyCrudController;
use App\Controller\Admin\CrudController\HomeCrudController;
use App\Entity\Cart;
use App\Entity\Type;
use App\Entity\User;
use App\Entity\Color;
use App\Entity\Order;
use App\Entity\Address;
use App\Entity\Carrier;
use App\Entity\Company;
use App\Entity\Package;
use App\Entity\Product;
use App\Entity\Appellation;
use App\Entity\Destination;
use App\Entity\ProductBrand;
use App\Entity\ProductCategory;
use App\Repository\CompanyRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;




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
        
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
        return $this->redirect($routeBuilder->setController(HomeCrudController::class)->generateUrl()); 
        // return $this->render('bundles/EasyAdminBundle/home/content.html.twig', [
        //     'companies' => $this->companies->findBy(['validated'=>0])
        // ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
        
            ->setTitle('<img src="/images/logoOwineBurgundry.png" height="50px" position="relative" bottom="0px"> ' . ' O\'Wine ' .  '<em>Admin dashboard</em>');

    }

    public function configureAssets(): Assets
    {
        return Assets::new()->addCssFile('css/admin.css');
    }

    public function configureMenuItems(): iterable
    {
        return [
            // Point de menu pour revenir sur la page d'accueil du dashboard
            MenuItem::linktoDashboard('Home','fa fa-landmark'),
            
            // Point de menu concernant les Utilisateurs
            MenuItem::linkToCrud('Users', 'fa fa-users', User::class),
            // MenuItem::section('Users', '', User::class),
            // MenuItem::subMenu('Users', 'fa fa-users')->setSubItems([
            //     MenuItem::linkToCrud('Admin', 'fas fa-user-shield', User::class),
            //     MenuItem::linkToCrud('Buyers', 'fa fa-user-friends', User::class)
            //     ->setController(BuyerCrudController::class),
            //     MenuItem::linkToCrud('Sellers', 'fas fa-user-tie', User::class),
                
            // ]),

            
            // Section invisible sur le front mais servant a créer un espace
            MenuItem::section('', ''),
        
             // Point de menu concernant les Adresses 
            MenuItem::linkToCrud('Address', 'fa fa-house-user', Address::class),

            // Point de menu concernant les Appellations de produit
            MenuItem::linkToCrud('Appellation', 'fas fa-bullhorn', Appellation::class),

            // Point de menu concernant les Marques de produit
            MenuItem::linkToCrud('Brand', 'fa fa-copyright', ProductBrand::class),

            // Point de menu concernant les Paniers
            MenuItem::linkToCrud('Cart', 'fa fa-shopping-cart', Cart::class),

            // Point de menu concernant les Categories de produit
            MenuItem::linkToCrud('Category', 'fa fa-tags', ProductCategory::class),
        
            // Point de menu concernant les Coleurs de produit (ex.: couleur du vin)
            MenuItem::linkToCrud('Color', 'fa fa-tint', Color::class),
        
            // Point de menu concernant les Entreprises vendant sur notre site
            MenuItem::linkToCrud('Company', 'fa fa-building', Company::class)
            ->setController(CompanyCrudController::class),        

            // Point de menu concernant les Commandes 
            MenuItem::linkToCrud('Destination', 'fa fa-map-marked-alt', Destination::class),
        
            // Point de menu concernant les Commandes intrégrant la liste des produits
            MenuItem::linkToCrud('Order', 'fa fa-file-text', Order::class),
        
            // Point de menu concernant le Conditionnement des produits
            MenuItem::linkToCrud('Package', 'fa fa-box-open', Package::class),

            // Point de menu concernant les Produits
            MenuItem::linkToCrud('Product', 'fa fa-glass', Product::class),

            // Point de menu concernant les Types de produit
            MenuItem::linkToCrud('Type', 'fa fa-th-large', Type::class),
        
                
            MenuItem::section('', ''),
            // point de menu pour la deconnexion
        
            MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
            
        ];

    }
}
