<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MentionslegalesController extends AbstractController
{
    /**
     * @Route("/mentionslegales", name="mentionslegales")
     */
    public function index(): Response
    {
        return $this->render('mentionslegales/index.html.twig', [
            'controller_name' => 'MentionslegalesController',
        ]);
    }
}
