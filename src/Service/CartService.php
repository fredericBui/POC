<?php

namespace App\Service;

use App\Entity\Poc;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    private $sessionInterface;

    // Construit une session
    public function __construct(SessionInterface $sessionInterface)
    {
        $this->sessionInterface = $sessionInterface;
    }

    // Recherche un panier dans la session
    public function get()
    {
        return $this->sessionInterface->get('cart', [
            // Si il n'y a pas de panier retourner le panier par défaut
            'elements' => [],
            'total' => 0.0
        ]);
    }

    // Ajoute un POC au panier
    public function add(Poc $Poc)
    {
        // Récupère un panier existant
        $cart = $this->get();

        // Récupère l'id du Poc
        $PocId = $Poc->getId();

        // Si l'id du Poc n'existe pas
        if(!isset($Poc['elements'][$PocId]))
        {
            $Poc['elements'][$PocId] = [
                'book' => $Poc,
                'quantity' => 0
            ];
        }

        // Ajoute le prix du livre au total du panier
        $cart['total'] = $cart['total'] + $Poc->getPrice();
        // Ajoute +1 au nombre d'élément du panier
        $cart['elements'][$PocId]['quantity'] = $cart['elements'][$PocId]['quantity'] + 1;

        // Enregistre le panier dans la session
        $this->sessionInterface->set('cart', $cart);
    }

    // Supprime un element du panier 
    public function remove(Poc $Poc)
    {
        // Récupère un panier existant
        $cart = $this->get();

        // Récupère l'id du Poc
        $PocId = $Poc->getId();

        // Si il n'y a pas le Poc en question dans le panier ne rien faire
        if(!isset($cart['elements'][$PocId]))
        {
            return;
        }

        // Déduis le prix du Poc du panier total
        $cart['total'] = $cart['total'] - $Poc->getPrice();

        // Ajoute -1 au nombre d'élément du panier
        $cart['elements'][$PocId]['quantity'] =  $cart['elements'][$PocId]['quantity'] - 1;

        // Enleve le Poc en question du panier si sa quantité est de zéro
        if ($cart['elements'][$PocId]['quantity'] <= 0){
            unset($cart['elements'][$PocId]);
        }

        // Enregistre le panier dans la session
        $this->sessionInterface->set('cart', $cart);
    }

    // Efface le panier
    public function clear()
    {
        // Supprime cart de la session
        $this->sessionInterface->remove('cart');
    }
}