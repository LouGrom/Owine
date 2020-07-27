<?php

namespace App\Controller;


use App\Entity\Product;
use App\Repository\AppellationRepository;
use App\Repository\ColorRepository;
use App\Repository\ProductBrandRepository;
use App\Repository\ProductRepository;
use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/shop")
 */
class ShopController extends AbstractController
{

    /**
     * @Route("/", name="product_list_shop")
     */
    public function list(ProductRepository $productRepository, ProductBrandRepository $productBrandRepository, TypeRepository $typeRepository, AppellationRepository $appellationRepository, ColorRepository $colorRepository)
    {
        if(isset($_GET['sortByPrice']) && ($_GET['sortByPrice'] == 1 or $_GET['sortByPrice'] == 0)){
            $sortByPrice = $_GET['sortByPrice'];
        } else {
            $sortByPrice = 1;
        }
        $productList = $productRepository->findAllSortByPrice($sortByPrice);

        if(isset($_GET['search'])){
            $search = $_GET['search'];
            $productList = $productRepository->searchProduct($search, $sortByPrice);
        } else {
            $search = '';
        }

        return $this->render('shop/list.html.twig', [
            'products' => $productList,
            'brands' => $productBrandRepository->findAll(),
            'types' => $typeRepository->findAll(),
            'appellations' => $appellationRepository->findAll(),
            'colors' => $colorRepository->findAll(),
            'sortByPrice' => $sortByPrice,
            'search' => $search
        ]);
    }


    /**
     * @Route("/seller/{id}", name="seller_shop")
     */
    public function sortBySeller(ProductRepository $productRepository, $id)
    {
        
        return $this->render('shop/list.html.twig', [
            'products' => $productRepository->findAllByCompany($id)
        ]);
    }

    /**
     * @Route("/{id}", name="product_show_shop", methods={"GET"})
     */
    public function show(Product $product= null): Response
    {   
        return $this->render('shop/show.html.twig', [
            'product' => $product,
        ]);
    }
}