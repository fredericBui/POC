<?php

namespace App\Controller;

use App\Entity\Poc;
use App\Repository\PocRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/catalog")
 */
class CatalogController extends AbstractController
{
    /**
     * @Route("/", name="catalog_index", methods={"GET"})
     */
    public function index(PocRepository $pocRepository): Response
    {
        return $this->render('catalog/index.html.twig', [
            // On retrouve les mêmes méthodes que j'expliquerais dans les repository
            'pocs' => $pocRepository->findAll(),
        ]);
    }
   
    /**
     * @Route("/{id}", name="catalog_show", methods={"GET"})
     */
    public function show(Poc $poc): Response
    {
        return $this->render('catalog/show.html.twig', [
            'poc' => $poc,
        ]);
    }

}
