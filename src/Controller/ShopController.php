<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class ShopController extends AbstractController
{

    /**
     * @Route("/products", name="products_list")
     */
    public function list(ProductRepository $productRepository)
    {
        return $this->render('product/list.html.twig', [
            'products' => $productRepository->findAll()
        ]);
    }


}