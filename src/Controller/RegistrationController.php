<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Company;
use App\Form\CompanyType;
use App\Form\UserType;
use App\Security\EmailVerifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class RegistrationController extends AbstractController
{
    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/register/", name="app_register")
     */
    public function register()
    {
        return $this->render('registration/register.html.twig');
    }    



    /**
     * @Route("/register/company", name="app_company_register")
     */
    public function companyRegister(Request $request): Response
    {
        $user = new User();
        $company = new Company();
        // Initialisation des valeurs par défaut
        $user->setRoles(['ROLE_USER','ROLE_SELLER']);
        $company->setValidated(0);

        $form = $this->createForm(UserType::class, $user);
        $formCompany = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);
        $formCompany->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On encode le mot de passe
            $user->setPassword(password_hash($user->getPassword(), PASSWORD_DEFAULT));
            // Puis on attribue l'entreprise à l'utilisateur créé
            $user->setCompany($company);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($company);
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash("success","Votre inscription est en cours de traitement, vous pouvez accéder à votre espace personnel dès à présent");

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/user.html.twig', [
            'company' => $company,
            'form' => $form->createView(),
            'formCompany' => $formCompany->createView(),
        ]);
    }

    /**
     * @Route("/register/customer", name="app_individual_register")
     */
    public function individualRegister(Request $request): Response
    {
        $user = new User();
        $user->setRoles(['ROLE_USER','ROLE_BUYER']);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $user->setPassword(password_hash($user->getPassword(), PASSWORD_DEFAULT));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash("success","Vous êtes bien inscrit sur le site, vous pouvez accéder à votre espace personnel dès à présent");

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/user.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    // /**
    //  * @Route("/verify/email", name="app_verify_email")
    //  */
    // public function verifyUserEmail(Request $request): Response
    // {
    //     $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

    //     // validate email confirmation link, sets User::isVerified=true and persists
    //     try {
    //         $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
    //     } catch (VerifyEmailExceptionInterface $exception) {
    //         $this->addFlash('verify_email_error', $exception->getReason());

    //         return $this->redirectToRoute('app_register');
    //     }

    //     // @TODO Change the redirect on success and handle or remove the flash message in your templates
    //     $this->addFlash('success', 'Your email address has been verified.');

    //     return $this->redirectToRoute('homepage');
    // }
}
