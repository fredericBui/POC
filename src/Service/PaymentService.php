<?php

// Service relatif à Stripe

namespace App\Service;

// Utilisation de la class StripeClient situé dans le vendor téléchargé avec composer
use \Stripe\StripeClient;

class PaymentService
{

    // Création de variable qui ne seront accessible qu'ici
    private $cartService;
    private $stripe;

    // Utilisation du service Cart créé précédement
    public function __construct(CartService $cartService)
    {
        // class cartservice dans variable cartservice
        $this->cartService = $cartService;

        // clef privé de stripe dans variable stripe
        $this->stripe = new StripeClient('sk_test_51KJgxzIhElw1NGJtdHhKTB3CF5J5WpBp9KFP9Qq77cfcjNninSd84kgVSdAcGkRWey1MJNTbAvco2xFcUjswrqZa00W5Bpgngu');

    }

    // Création d'un paiement à partir des éléments du panier
    public function create() :string
    {
        // les élément du panier dans variable cart
        $cart = $this->cartService->get();
        // Création d'un tableau
        $items = [];
        // Pour chaque élément dans le cart ajouter un élément dans le tableau items
        foreach ($cart['element'] as $bookId => $element)
        {
            $items[] = [
                'amount' => $element['poc']->getPrice() * 100,
                'quantity' => $element['quantity'],
                'currency' => 'eur',
                'name' => $element['poc']->getTitle()
            ];
        }

        $protocol = $_SERVER['HTTPS'] ? 'https' : 'http';
        $host = $_SERVER['SERVER_NAME'];
        $successUrl = $protocol . '://' . $host . '/payment/success/{CHECKOUT_SESSION_ID}';
        $failureUrl = $protocol . '://' . $host . '/payment/failure/{CHECKOUT_SESSION_ID}';

        $session = $this->stripe->checkout->session->create([
            'succes_url' => $successUrl,
            'cancel_url' => $failureUrl,
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'line_items' => $items
        ]);

        return $session->id;
    }
}