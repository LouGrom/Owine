<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Service\VignoblexportApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/order")
 */
class OrderController extends AbstractController
{
    /**
     * @Route("/", name="order_list", methods={"GET"})
     */
    public function index(OrderRepository $orderRepository): Response
    {
        return $this->render('order/list.html.twig', [
            'orders' => $orderRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="order_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Order $order): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($order);
            $entityManager->flush();

            $this->addFlash("success","La commande a bien été supprimée");
        }

        return $this->redirectToRoute('board');
    }

    /**
     * @Route("/{id}/ship", name="order_ship", requirements={"id" = "\d+"}, methods={"GET","POST"})
     */
    public function shipOrder(OrderRepository $orderRepository, VignoblexportApi $vignoblexportApi, $id)
    {
        $order = $orderRepository->find($id);
        $vignoblexportApi->createShipment($order);

    }
}
