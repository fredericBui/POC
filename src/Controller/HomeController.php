<?php

// Ceci est le plus basique des controller qu'on puisse trouver
// Il retourne une vue et fais passer une variable twig

namespace App\Controller;

use App\Repository\PocRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(PocRepository $pocRepository, SessionInterface $sessionInterface): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'pocs' => $pocRepository->findBy(
                ['author' => '1']
            )
        ]);
    }

}
