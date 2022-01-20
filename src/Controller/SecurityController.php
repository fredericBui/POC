<?php

// Controller de connexion

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    // Ici on utilise une class spécial pour la connexion celle ci utilise par exemple la class request pour récupérer des données
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user, est-ce que c'est à cause de cette méthode que lorsque je reviens sur un formulaire, je vois l'ancien identifiant que j'ai entré ?
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        //Exception that represents error in the program logic. This kind of exception should lead directly to a fix in your code.
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
