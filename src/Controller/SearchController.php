<?php

namespace App\Controller;

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
        $products = $productRepository->searchProduct($search);
        $appellations = $appellationRepository->searchAppellation($search);
        foreach($appellations as $appellation) 
        {
            $productsByAppellation[] = $productRepository->findAllByAppellation($appellation);
        }
        if (!empty($productsByAppellation)) {
            foreach ($productsByAppellation as $appellation) {
                foreach ($appellation as $product) {
                    if (!in_array($product, $products)) {
                        $products[] = $product;
                    }
                }
            }
        }

        // dump($productsByAppellation);
        // dump($companies);
        // dump($products);
        // dd($appellations);

        return $this->render('search/result.html.twig', [
            'companies' => $companies,
            'appellations' => $appellations,
            'products'=> $products,
        ]);
    }
}
