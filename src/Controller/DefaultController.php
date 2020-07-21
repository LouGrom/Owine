<?php

namespace App\Controller;

use App\Repository\CompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepage(CompanyRepository $companyRepository, Request $request): Response
    {
        return $this->render('default/homepage.html.twig', [
            'companies' => $companyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/contacts", name="contacts")}}
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
}
