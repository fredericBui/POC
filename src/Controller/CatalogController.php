<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Poc;
use App\Repository\CategoryRepository;
use App\Repository\PocRepository;
use Doctrine\ORM\Mapping\Id;
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
    public function index( Request $request, PocRepository $pocRepository, CategoryRepository $categoryRepository): Response
    {
        $data = $request->query->get('keyword');
        $data2 = $request->query->get('category');
        $category = $categoryRepository->findBy(["name"=>$data2]);

        if($data){
            return $this->render('catalog/index.html.twig', [
                //Recherche par mot clé
                'pocs' => $pocRepository->findByText($data)
            ]);    
        } elseif($data2){
            return $this->render('catalog/index.html.twig', [
                //Recherche par mot clé
                'pocs' => $pocRepository->getCategory($category[0])
            ]);
        }else{
            return $this->render('catalog/index.html.twig', [
                // On retrouve les mêmes méthodes que j'expliquerais dans les repository
                'pocs' => $pocRepository->findAll(),
            ]);
        }   
    }

}
