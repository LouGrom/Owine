<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Address;
use App\Entity\Destination;
use App\Form\AddressType;
use App\Form\UserType;
use App\Repository\DestinationRepository;
use App\Repository\PackageRepository;
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
    public function index(UserRepository $userRepository, DestinationRepository $destinationRepository, PackageRepository $packageRepository):Response
    {
        $datas = [];
        if (in_array('ROLE_SELLER', $this->getUser()->getRoles())) {
            $company = $this->getUser()->getCompany();
            $companyId = $company->getId();
            $datas = [
                'destinations' => $destinationRepository->findAll(),
                'packages' => $packageRepository->findAllByBottleQuantity($companyId)
            ];
        }
        
        return $this->render('user/profile.html.twig', $datas);
    }

    /**
     * @Route("/{params}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserRepository $userRepository, $params, DestinationRepository $destinationRepository): Response
    {
        $user = new User();
        $address = new Address();
        $destinations = $destinationRepository->findAll();
                
        $user = $this->getUser();
        $address = $user->getAddresses()[0];

        if ($params == 'personal') {
            $object = $user;
            $form = $this->createForm(UserType::class, $object);
        } elseif ($params == 'address') {
            $object = $address;
            $form = $this->createForm(AddressType::class, $object);
        }
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash("success", "L'utilisateur a bien été modifié");

            return $this->redirectToRoute('profil');
        }

        return $this->render('user/edit.html.twig', [
            'destinations' => $destinations,
            'form' => $form->createView(),
        ]);
    }
}