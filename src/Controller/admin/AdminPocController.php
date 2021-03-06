<?php

namespace App\Controller\admin;

use App\Entity\Poc;
use App\Form\PocType;
use App\Repository\PocRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/poc")
 */
class AdminPocController extends AbstractController
{
    /**
     * @Route("/", name="admin_poc_index", methods={"GET"})
     */
    public function index(PocRepository $pocRepository): Response
    {
        return $this->render('admin/admin_poc/index.html.twig', [
            'pocs' => $pocRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_poc_new", methods={"GET", "POST"})
     */
    public function new(Request $request,FileUploader $fileUploader, EntityManagerInterface $entityManager, SessionInterface $sessionInterface): Response
    {
        $poc = new Poc();
        $form = $this->createForm(PocType::class, $poc);
        $form->handleRequest($request);
        $poc->setAuthor($this->getUser());

        if ($form->isSubmitted() && $form->isValid()) {
            
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $imageFileName = $fileUploader->upload($imageFile);
                $poc->setImageFilename($imageFileName);
            }
            
            $entityManager->persist($poc);
            $entityManager->flush();

            return $this->redirectToRoute('admin_poc_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_poc/new.html.twig', [
            'poc' => $poc,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_poc_show", methods={"GET"})
     */
    public function show(Poc $poc): Response
    {
        return $this->render('admin/admin_poc/show.html.twig', [
            'poc' => $poc,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_poc_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request,FileUploader $fileUploader , Poc $poc, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PocType::class, $poc);
        $form->handleRequest($request);
        $poc->setAuthor($poc->getAuthor());
        
        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $imageFileName = $fileUploader->upload($imageFile);
                $poc->setImageFilename($imageFileName);
            }
            
            $entityManager->flush();

            return $this->redirectToRoute('admin_poc_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_poc/edit.html.twig', [
            'poc' => $poc,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_poc_delete", methods={"POST"})
     */
    public function delete(Request $request, Poc $poc, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$poc->getId(), $request->request->get('_token'))) {
            $entityManager->remove($poc);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_poc_index', [], Response::HTTP_SEE_OTHER);
    }
}
