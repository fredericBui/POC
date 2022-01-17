<?php

namespace App\Controller;

use App\Entity\Language;
use App\Form\LanguageType;
use App\Repository\LanguageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/language")
 */
class AdminLanguageController extends AbstractController
{
    /**
     * @Route("/", name="admin_language_index", methods={"GET"})
     */
    public function index(LanguageRepository $languageRepository): Response
    {
        return $this->render('admin_language/index.html.twig', [
            'languages' => $languageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_language_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $language = new Language();
        $form = $this->createForm(LanguageType::class, $language);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($language);
            $entityManager->flush();

            return $this->redirectToRoute('admin_language_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_language/new.html.twig', [
            'language' => $language,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_language_show", methods={"GET"})
     */
    public function show(Language $language): Response
    {
        return $this->render('admin_language/show.html.twig', [
            'language' => $language,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_language_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Language $language, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LanguageType::class, $language);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_language_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_language/edit.html.twig', [
            'language' => $language,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_language_delete", methods={"POST"})
     */
    public function delete(Request $request, Language $language, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$language->getId(), $request->request->get('_token'))) {
            $entityManager->remove($language);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_language_index', [], Response::HTTP_SEE_OTHER);
    }
}
