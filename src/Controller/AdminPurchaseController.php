<?php

namespace App\Controller;

use App\Entity\Purchase;
use App\Form\PurchaseType;
use App\Repository\PurchaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/purchase")
 */
class AdminPurchaseController extends AbstractController
{
    /**
     * @Route("/", name="admin_purchase_index", methods={"GET"})
     */
    public function index(PurchaseRepository $purchaseRepository): Response
    {
        return $this->render('admin_purchase/index.html.twig', [
            'purchases' => $purchaseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_purchase_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $purchase = new Purchase();
        $form = $this->createForm(PurchaseType::class, $purchase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($purchase);
            $entityManager->flush();

            return $this->redirectToRoute('admin_purchase_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_purchase/new.html.twig', [
            'purchase' => $purchase,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_purchase_show", methods={"GET"})
     */
    public function show(Purchase $purchase): Response
    {
        return $this->render('admin_purchase/show.html.twig', [
            'purchase' => $purchase,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_purchase_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Purchase $purchase, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PurchaseType::class, $purchase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_purchase_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_purchase/edit.html.twig', [
            'purchase' => $purchase,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_purchase_delete", methods={"POST"})
     */
    public function delete(Request $request, Purchase $purchase, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$purchase->getId(), $request->request->get('_token'))) {
            $entityManager->remove($purchase);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_purchase_index', [], Response::HTTP_SEE_OTHER);
    }
}
