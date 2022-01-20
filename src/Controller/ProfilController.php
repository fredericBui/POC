<?php

// Schéma similaire aux admincontroller sauf qu'on a supprimer index, new et delete
// L'idée ici est de donner la possibilité à l'utilisateur de pouvoir seulement voir et modifier son profil

namespace App\Controller;

use App\Entity\User;
use App\Form\User1Type;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profil")
 */
class ProfilController extends AbstractController
{
    
    /**
     * @Route("/", name="profil_show", methods={"GET"})
     */
    public function show(): Response
    {
        // C'est cette méthode qui permet de récupérer l'utilisateur actuellement connecter
        $user = $this->getUser();
        return $this->render('profil/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/edit", name="profil_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Idem modification sur l'utilisateur actuellement connecté
        $user = $this->getUser();

        // Ici on fais appelle à un form spécial pour l'utilisateur
        // Je viens de comprendre que le deuxième paramètre de createForm permet de remplir les values du form avec ce que contient user
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('profil_show', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profil/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

}
