<?php

// Le cart controller est différent des autres car il dépend du cartservice

namespace App\Controller;

use App\Entity\Poc;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart_index")
     */
    public function index(CartService $cartService): Response
    {
        // Ici nous avons créé un panier qui va utiliser la méthode get de la class cartservice
        // J'expliquerais dans la classe cartservice ce que fais get
        $cart = $cartService->get();

        // Rien de nouveau mis à pars qu'on fais passer la variable car à la vue
        // Ce que je trouve intéressant à ce niveau c'est que je comprends qu'un controller suis souvent ce schéma :
        // namespace, use, création de la class + héritage, fonction + injection de dépendance dans laquelle on fais appelle au méthode des class injectées avec dans tous les cas une redirection et des passages à la vue si besoin
        return $this->render('cart/index.html.twig', [
            'cart' => $cart
        ]);
    }

    /**
     * @Route("/cart/add/{id}", name="cart_add")
     */
    public function add(CartService $cartService, Poc $poc)
    {
        $cartService->add($poc);

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/cart/remove/{id}", name="cart_remove")
     */
    public function remove(CartService $cartService, Poc $poc): Response
    {
        $cartService->remove($poc);

        return $this->redirectToRoute('cart_index');
    }

    /**
     * @Route("/cart/clear/", name="cart_clear")
     */
    public function clear(CartService $cartService): Response
    {
        $cartService->clear();

        return $this->redirectToRoute('cart_index');
    }
}
