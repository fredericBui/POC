<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CguCgvController extends AbstractController
{
    /**
     * @Route("/cguCgv", name="cguCgv")
     */
    public function index(): Response
    {
        return $this->render('cguCgv/index.html.twig');
    }
}
