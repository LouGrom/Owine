<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    // /**
    //  * @Route("/admin/user", name="admin_user", methods="GET")
    //  */
    public function admin(UserRepository $userRepository)
    {
        return $this->render('user/admin.html.twig', [
            'users' => $userRepository->findAll()
        ]);
    }

    
}
