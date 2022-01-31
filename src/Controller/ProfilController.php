<?php

// Schéma similaire aux admincontroller sauf qu'on a supprimer index, new et delete
// L'idée ici est de donner la possibilité à l'utilisateur de pouvoir seulement voir et modifier son profil

namespace App\Controller;

use App\Entity\Poc;
use App\Form\PocType;
use App\Form\User1Type;
use App\Repository\PocRepository;
use App\Service\FileUploader;
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
        // Le deuxième paramètre de createForm permet de remplir les values du form avec ce que contient user
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

    /**
     * @Route("/addPoc", name="profil_addPoc", methods={"GET", "POST"})
     */
    public function addPoc(PocRepository $pocRepository, EntityManagerInterface $entityManager, Request $request, FileUploader $fileUploader): Response
    {

        $poc = new Poc();
        $form = $this->createForm(PocType::class, $poc);
        $form->handleRequest($request);
        // Ici on force notre nouveau poc à avoir l'adresse mail de l'utilisateur actuel
        $poc->setAuthor($this->getUser());

        if ($form->isSubmitted() && $form->isValid()) {
            
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $imageFileName = $fileUploader->upload($imageFile);
                $poc->setImageFilename($imageFileName);
            }
            
            $entityManager->persist($poc);
            $entityManager->flush();

            return $this->redirectToRoute('profil_myPoc', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_poc/new.html.twig', [
            'poc' => $poc,
            'form' => $form,
        ]);

    }

    /**
     * @Route("/myPoc", name="profil_myPoc", methods={"GET"})
     */
    public function myPoc(PocRepository $pocRepository): Response
    {
        return $this->render('profil/myPoc.html.twig', [
            // Sélectionne uniquement les poc de l'utilisateur connecté
            'pocs' => $pocRepository->findBy(
                ['author' => $this->getUser()]
        )]);
    }

    /**
     * @Route("/myPoc/{id}", name="profil_myPoc_show", methods={"GET"})
     */
    public function myPocShow(Poc $poc): Response
    {
        //Si la personne connectée ne correspond pas à l'auteur du poc il est redirigé
        if($poc->getAuthor() == $this->getUser()){
            return $this->render('profil/myPocShow.html.twig', [
                'poc' => $poc,
            ]);
        }else{
            return $this->redirectToRoute('profil_myPoc', [], Response::HTTP_SEE_OTHER);
        }
        
    }

    /**
     * @Route("myPoc/{id}/edit", name="profil_myPoc_edit", methods={"GET", "POST"})
     */
    public function myPocedit(Request $request,FileUploader $fileUploader , Poc $poc, EntityManagerInterface $entityManager): Response
    {
        if($poc->getAuthor() == $this->getUser()){
            $form = $this->createForm(PocType::class, $poc);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $imageFile = $form->get('image')->getData();
                if ($imageFile) {
                    $imageFileName = $fileUploader->upload($imageFile);
                    $poc->setImageFilename($imageFileName);
                }
                
                $entityManager->flush();

                return $this->redirectToRoute('profil_myPoc', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('profil/myPocEdit.html.twig', [
                'poc' => $poc,
                'form' => $form,
            ]);
        }else{
            return $this->redirectToRoute('profil_myPoc', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("myPoc/{id}", name="profil_poc_delete", methods={"POST"})
     */
    public function delete(Request $request, Poc $poc, EntityManagerInterface $entityManager): Response
    {
        if($poc->getAuthor() == $this->getUser()){
            if ($this->isCsrfTokenValid('delete'.$poc->getId(), $request->request->get('_token'))) {
                $entityManager->remove($poc);
                $entityManager->flush();
            }

            return $this->redirectToRoute('profil_myPoc', [], Response::HTTP_SEE_OTHER);
        }else{
            return $this->redirectToRoute('profil_myPoc', [], Response::HTTP_SEE_OTHER);
        }
    }

}
