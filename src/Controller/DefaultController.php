<?php

namespace App\Controller;

use App\Entity\Company;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CompanyRepository;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepage(CompanyRepository $companyRepository): Response
    {
        return $this->render('default/homepage.html.twig', [
            'companies' => $companyRepository->findAll(),
        ]);
    }

     /**
     * @Route("/contacts", name="contacts")
     */
    public function contacts()
    {
        return $this->render('default/contacts.html.twig');
    }

    /**
     * @Route("/legal-mentions", name="legal_mentions")
     */
    public function legal()
    {
        return $this->render('default/legal_mentions.html.twig');
    }

    /**
     * @route("/404", name="error404")
     */
    public function error404()
    {
        return $this->render('default/error404.html.twig');
    }
}
