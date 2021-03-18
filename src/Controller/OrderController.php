<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Service\VignoblexportApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
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
    public function index(OrderRepository $orderRepository, ProductRepository $productRepository): Response
    {

        return $this->render('order/list.html.twig', [
            'orders' => $orderRepository->findAll(),
            'product' => $productRepository->findAll(),
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
        $entityManager = $this->getDoctrine()->getManager();

        foreach($order->getOrderProducts() as $orderProduct) {

            $product = [
                'appellation' => $orderProduct->getProduct()->getAppellation()->getName(),
                'origin' => $order->getCompany()->getSeller()[0]->getAddresses()[0]->getCountry(),
                'description' => $orderProduct->getProduct()->getDescription(),
                'capacity' => $orderProduct->getProduct()->getCapacity(),
                'degre' => $orderProduct->getProduct()->getAlcoholVolume(),
                'color' => $orderProduct->getProduct()->getColor()->getName(),
                'hsCode' => $orderProduct->getProduct()->getHsCode(),
                'millesime' => $orderProduct->getProduct()->getVintage(),
                'unitValue' => $orderProduct->getProduct()->getPrice(),
                'quantity' => $orderProduct->getQuantity(),
                'manufacturer' => $orderProduct->getProduct()->getBrand()->getName(),
            ];

            $commodityDetails[] = $product;
            
        }

        $packageList = $vignoblexportApi->selectPackage($order);

        $carrierDetails = $vignoblexportApi->estimateShippingCosts($order);
        // dump($carrierDetails);

        $content = $vignoblexportApi->createShipment($order, $packageList, $carrierDetails, $commodityDetails);
        // dump($content['expedition']['id']);
        $order->setReference($content['expedition']['id']);
        $order->setCarrier($carrierDetails['name']);
        $order->setTrackingNumber($content['expedition']['codeTracking']);
        $order->setShippingCosts($carrierDetails['price']);
        $order->setShippingLabel($content['expedition']['label']['directLink']);
        $order->setStatus(3);
        $manager = $this->getDoctrine()->getManager();
        $entityManager->persist($order);
        $entityManager->flush();

        return $this->redirectToRoute('order_view', [
            'id' => $id
        ]);
    }

    /**
     * @Route("/{id}/label", name="order_shiping_label", requirements={"id" = "\d+"}, methods={"GET","POST"})
     */
    public function getShippingLabel(VignoblexportApi $vignoblexportApi, OrderRepository $orderRepository, $id)
    {
        $order = $orderRepository->find($id);

        $content = $vignoblexportApi->getShippingLabel($order);
        // dd($content);
        $order->setStatus(3);
        $order->setShippingLabel($content);
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($order);
        $manager->flush();
        
        return $this->redirectToRoute('order_view', [
            'pdf' => $content,
            'id' => $id
        ]);

    }
}
