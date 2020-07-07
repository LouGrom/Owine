<?php

namespace App\Controller\Admin;

use App\Controller\UserController;
use App\Entity\User;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin", methods={"GET"})
     */
    public function index(): Response
    {
        //$users = $userRepository->findAll();
        return parent::index();

        // redirect to some CRUD controller
        //$routeBuilder = $this->get(CrudUrlGenerator::class)->build();

        //return $this->redirect($routeBuilder->setController(UserController::class)->generateUrl());

        // you can also redirect to different pages depending on the current user
        //if ('jane' === $this->getUser()->getUsername()) {
        //    return $this->redirect('...');
        //}

        // you can also render some template to display a proper Dashboard
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //return $this->render('user/test.html.twig', [
        //    'users' => $users,
        //]);

        // return $this->render('user/admin.html.twig');
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

            // MenuItem::linkToLogout('Logout', 'fa fa-exit'),
        ];

    }
}
