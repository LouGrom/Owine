<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BoardController extends AbstractController
{
    /**
     * @Route("/board", name="board")
     */
    public function board()
    {
        $productsList=$this->getDoctrine()->getRepository(Product::class)->findAll();
        $ordersList=$this->getDoctrine()->getRepository(Order::class)->findAll();
        return $this->render('board/board.html.twig', [
            'productsList' => $productsList,
            'ordersList'=> $ordersList
        ]);
    }

    /**
     * @Route("/product/{id}/view", name="product_view", requirements={"id" = "\d+"})
     */
    public function viewProduct($id)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);

        return $this->render('board/viewProduct.html.twig', [
            "product" => $product
        ]);
    }

      /**
     * @Route("/order/{id}/view", name="order_view", requirements={"id" = "\d+"})
     */
    public function viewOrder($id)
    {
        $order = $this->getDoctrine()->getRepository(Order::class)->find($id);

        return $this->render('board/viewOrder.html.twig', [
            "order" => $order
        ]);
    }
}
