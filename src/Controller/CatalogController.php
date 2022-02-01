<?php

namespace App\Controller;

use App\Entity\Poc;
use App\Repository\PocRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/show/{id}", name="catalog_show", methods={"GET"})
     */
    public function show(Poc $poc): Response
    {
        return $this->render('catalog/show.html.twig', [
            'poc' => $poc,
        ]);
    }

    /**
     * @Route("/search", name="catalog_search", methods={"GET"})
     */
    public function search(PocRepository $pocRepository, Request $request): Response
    {
        $data = $request->query->get('keyword');
        //$data = $request->query;
        //dd($data);
        return $this->render('catalog/index.html.twig', [
            //Recherche par mot clé
            'pocs' => $pocRepository->findByText($data)]);
    }

}
