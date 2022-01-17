<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class POCController extends AbstractController
{
    /**
     * @Route("/poc", name="poc")
     */
    public function index(): Response
    {
        return $this->render('poc/index.html.twig', [
            'controller_name' => 'POCController',
        ]);
    }
}
