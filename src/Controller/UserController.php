<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Address;
use App\Entity\Destination;
use App\Form\AddressType;
use App\Form\UserType;
use App\Repository\AddressRepository;
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
     * @Route("/user", name="profile", methods={"GET"})
     */
    public function index(AddressRepository $addressRepository, UserRepository $userRepository, DestinationRepository $destinationRepository, PackageRepository $packageRepository):Response
    {

        $user = $this->getUser();
        // dump($user['addresses']['0']);

        $form = $this->createForm(UserType::class, $user);

        $datas = [];
        $datas['form'] = $form->createView();

        if (in_array('ROLE_SELLER', $user->getRoles())) {
            $company = $this->getUser()->getCompany();
            $companyId = $company->getId();
            $datas['destinations'] =  $destinationRepository->findAll();
            $datas['packages'] = $packageRepository->findAllByBottleQuantity($companyId);
        }
        
        return $this->render('user/profile.html.twig', $datas);
    }

    /**
     * @Route("/personal/edit", name="edit_user_infos", methods={"POST"})
     */
    public function changeInfos(Request $request)
    {
        
        $user = $this->getUser();

        $user->setFirstname($_POST['user']['firstname']);
        $user->setLastname($_POST['user']['lastname']);
        $user->setEmail($_POST['user']['email']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('user_edit');
    }

    /**
     * @Route("/password/edit", name="edit_user_password", methods={"POST"})
     */
    public function changePassword(Request $request)
    {
        $user = $this->getUser();
        $oldPassword = $_POST['user']['oldPassword'];
        $newPassword1 = $_POST['user']['password']['first'];
        $newPassword2 = $_POST['user']['password']['second'];
        if(password_verify($oldPassword, $user->getPassword())) {

            if($newPassword1 == $newPassword2) {

                $user->setPassword(password_hash($newPassword1, PASSWORD_DEFAULT));
            
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                $this->addFlash("success", "Votre mot de passe a bien été modifié");
            } else {

                $this->addFlash("danger", "Vous devez taper deux fois votre nouveau mot de passe");
            }
        } else {

            $this->addFlash("danger", "Mauvais mot de passe (banane)");
        }

        return $this->redirectToRoute('user_edit');
    }

    /**
     * @Route("/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DestinationRepository $destinationRepository): Response
    {
        $user = new User();
        $destinations = $destinationRepository->findAll();
                
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash("success", "L'utilisateur a bien été modifié");

            return $this->redirectToRoute('profile');
        }

        return $this->render('user/edit.html.twig', [
            'destinations' => $destinations,
            'form' => $form->createView(),
        ]);
    }

}