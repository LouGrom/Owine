<?php

namespace App\Controller;


use App\Entity\Product;
use App\Repository\ProductRepository;
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
    public function list(ProductRepository $productRepository)
    {
        return $this->render('shop/list.html.twig', [
            'products' => $productRepository->findAll()
        ]);
    }

    /**
     * @Route("/seller/{id}", name="seller_shop")
     */
    public function sortBySeller(ProductRepository $productRepository, $id)
    {
        
        return $this->render('shop/list.html.twig', [
            'products' => $productRepository->findAllBySeller($id)
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