<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Address;
use App\Entity\Destination;
use App\Form\AddressType;
use App\Form\UserType;
use App\Repository\DestinationRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="profil", methods={"GET"})
     */
    public function index(UserRepository $userRepository):Response
    {
        return $this->render('user/profile.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserRepository $userRepository, $id, DestinationRepository $destinationRepository): Response
    {
        $user = new User();
        $address = new Address();
        $destinations = $destinationRepository->findAll();
                

        $user = $userRepository->find($id);
        $address = $user->getAddresses()[0];
        
        $userForm = $this->createForm(UserType::class, $user);
        $addressForm = $this->createForm(AddressType::class, $address);
        $userForm->handleRequest($request);
        $addressForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash("success", "L'utilisateur a bien été modifié");

            return $this->redirectToRoute('profil');
        }

        return $this->render('user/edit.html.twig', [
            'users' => $userRepository->findAll(),
            'addressForm' => $addressForm->createView(),
            'userForm' => $userForm->createView(),
            'destinations' => $destinations,
        ]);
    }
}
