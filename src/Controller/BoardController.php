<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/board")
 */
class BoardController extends AbstractController
{
    /**
     * @Route("/", name="board")
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

    /**
     * @Route("/product/new", name="product_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash("success","Le produit a bien été ajouté");

            return $this->redirectToRoute('board');
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/product/{id}/edit", name="product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash("success", "Le produit a bien été modifié");

            return $this->redirectToRoute('board');
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/product/{id}", name="product_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();

            $this->addFlash("success", "Le produit a bien été supprimé");
        }

        return $this->redirectToRoute('board');
    }
}
