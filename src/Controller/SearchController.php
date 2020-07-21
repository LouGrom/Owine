<?php

namespace App\Controller;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function search(Request $request): Response
    {

        /** @var CompanyRepository */
        $companyRepository = $this->getDoctrine()->getRepository(Company::class);
        
        
        $search = $_POST['search'];

        // je peux utiliser ma methode de repository personnalisé
        $company = $companyRepository->findByCompanyName($search);
        
        //$product = $ProductRepository->findAllByCompany($search);

        return $this->render('company/list.html.twig', [
            'companies' => $company
        ]);
    }
}
