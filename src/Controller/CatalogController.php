<?php

namespace App\Controller;

use App\Entity\Poc;
use App\Form\Poc1Type;
use App\Repository\PocRepository;
use Doctrine\ORM\EntityManagerInterface;
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
