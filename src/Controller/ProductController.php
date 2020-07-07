<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class ProductController extends AbstractController
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
    
    // /**
    //  * @Route("/products/{id}", name="products_view", requirements={"id"="\d+"})
    //  */
    // public function view($id, ProductRepository $productRepository)
    // {
    //     $product = $productRepository->findBy($id);

    //     if(empty($product)) {
    //         throw $this->createNotFoundException("This product does not exist");
    //     }

    //     return $this->render('product/view.html.twig', [
    //         'product' => $product
    //     ]);

    // }


}