<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart")
 */
class CartController extends AbstractController
{

    /**
     * @Route("/{id}/customer", name="cart_buyer", methods={"GET"})
     */
    public function buyerCart(CartRepository $cartRepository, $id): Response
    {
        return $this->render('cart/buyer_cart.html.twig', [
            'carts' => $cartRepository->findAllByBuyer($id)
        ]);
    }

    /**
     * @Route("/{productId}/add", name="add_cart", methods={"GET"})
     */
    public function addCart(CartRepository $cartRepository, ProductRepository $productRepository, $productId): Response
    {
        $cart = new Cart();
        // On peut récupérer l'utilisateur courant avec $this->getUser()
        $userId = $this->getUser()->getId();
        $product = $productRepository->find($productId);

        // On vérifie qu'un cart n'existe pas déjà entre l'utilisateur et le produit.
        $result = $cartRepository->findExistingCart($userId, $productId);

        // Si un cart existe déjà et que le produit est en vente
        // Alors on récupère le premier (et normalement unique) résultat
        if(isset($result[0]) && $product->getStatus() != 0) {

            $cart = $result[0];
            // On ajoute 1 à la quantité
            $cart->setQuantity($cart->getQuantity() + 1);
            // Puis on met à jour le montant total
            $cart->setTotalAmount($cart->getTotalAmount() + $product->getPrice());
        } else {

            // Si il n'existe pas, on en créé un nouveau
            $cart->setUser($this->getUser());
            // On vérifie au préalable que le produit existe bel et bien en BDD et qu'il est en vente
            if(!empty($product) && $product->getStatus() != 0) {

                $cart->setProduct($product);
            } else {
                $this->addFlash("warning","Le produit n'existe pas ou n'est plus en vente.");
                return $this->redirectToRoute('product_list_shop');
            }
            // On initialise la quantité du nouveau cart à 1
            $cart->setQuantity(1);
            // Ainsi que le montant total
            $cart->setTotalAmount($product->getPrice());
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($cart);
        $entityManager->flush();
        $this->addFlash("success","Le produit a bien été ajouté à votre panier !");
        return $this->redirectToRoute('product_show_shop', ['id' => $productId]);
    }

    /**
     * @Route("/{id}", name="cart_show", methods={"GET"})
     */
    public function show(Cart $cart): Response
    {
        return $this->render('cart/show.html.twig', [
            'cart' => $cart,
        ]);
    }

    /**
     * @Route("/{id}", name="cart_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Cart $cart): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cart->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cart);
            $entityManager->flush();

            $this->addFlash("success","Le panier a bien été supprimé");
        }

        return $this->redirectToRoute('cart_buyer');
    }
}
