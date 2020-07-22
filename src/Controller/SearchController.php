<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Product;
use App\Entity\Appellation;
use App\Repository\CompanyRepository;
use App\Repository\ProductRepository;
use App\Repository\AppellationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function search(CompanyRepository $companyRepository, ProductRepository $productRepository, AppellationRepository $appellationRepository): Response
    {
        $search = $_POST['search'];
        
        // je peux utiliser ma methode de repository personnalisé
        $companies = $companyRepository->searchCompany($search);
        $appellations = $appellationRepository->searchAppellation($search);
    
        dd($companies, $appellations, $companyRepository, $appellationRepository);
        return $this->render('search/result.html.twig', [
            'companies' => $companies,
            'appellations' => $appellations
        ]);
    }
}
