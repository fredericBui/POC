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

    // Ajoute un poc au panier
    public function add(Poc $poc)
    {
        // Récupère un panier existant
        $cart = $this->get();

        // Récupère l'id du poc
        $pocId = $poc->getId();

        // Si l'id du poc n'existe pas dans les éléments du panier cart
        if(!isset($cart['elements'][$pocId]))
        {
            $cart['elements'][$pocId] = [
                'poc' => $poc,
                'quantity' => 0
            ];
        }

        // Ajoute le prix du POC au total du panier
        $cart['total'] = $cart['total'] + $poc->getPrice();
        // Ajoute +1 au nombre d'élément du panier
        $cart['elements'][$pocId]['quantity'] = $cart['elements'][$pocId]['quantity'] + 1;

        // Enregistre le panier dans la session
        $this->sessionInterface->set('cart', $cart);
    }

    // Supprime un element du panier 
    public function remove(Poc $poc)
    {
        // Récupère un panier existant
        $cart = $this->get();

        // Récupère l'id du poc
        $pocId = $poc->getId();

        // Si il n'y a pas le poc en question dans le panier ne rien faire
        if(!isset($cart['elements'][$pocId]))
        {
            return;
        }

        // Déduis le prix du poc du panier total
        $cart['total'] = $cart['total'] - $poc->getPrice();

        // Ajoute -1 au nombre d'élément du panier
        $cart['elements'][$pocId]['quantity'] =  $cart['elements'][$pocId]['quantity'] - 1;

        // Enleve le poc en question du panier si sa quantité est de zéro
        if ($cart['elements'][$pocId]['quantity'] <= 0){
            unset($cart['elements'][$pocId]);
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