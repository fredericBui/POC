<?php
// Ce fichier permet de faire des cruds sur les category

// Indique l'emplacement du fichier ?
namespace App\Controller;

// Importe tous les fichiers nécessaires par leur namespace et nom de class
use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Ci-dessous une annotation permettant de créer la route principale de ce fichier

/**
 * @Route("/admin/category")
 */

 // Class de ce fichier qui hérite des propriétés et méthodes de la class AbstractController.
 class AdminCategoryController extends AbstractController
{
    // Toutes les annotations suivantes sont des sous-routes de admin/category

    // Ici la route est le nom de notre site
    // name est le chemin interne que nous pourrons réutiliser avec la fonction twig path
    // la méthods get nous indique que cette fonction retournera uniquement un affichage

    /**
     * @Route("/", name="admin_category_index", methods={"GET"})
     */

     //Ici on utilise l'autowiring en paramètre de index ce qui nous permet de créer un objet à partir d'un class
     // L'objet ainsi créer pourra être utiliser dans la fonction

    public function index(CategoryRepository $categoryRepository): Response
    {
        // La fonction index retourne la vue qui se situe dans le dossier admin_category et fait passer la variable twig categories à la vue
        // La méthode findAll de la class CategoryRepository permet de récupérer toute les catégories existantes et de les mettre dans la variable twig categories
        return $this->render('admin_category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    // la méthods post nous indique que cette fonction retournera des données saisies par l'utilisateur
    /**
     * @Route("/new", name="admin_category_new", methods={"GET", "POST"})
     */

    // Ici on utilise la class EntityManagerInterface qui nous permet de faire des modification en base de donnée
    // La class Request permet de récupéré des données
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {

        // Création d'une nouvelle catégorie à partir de l'entité Category
        $category = new Category();

        // Création d'un formulaire à partir de la class categoryType
        // Les données du formulaire iront dans category ?
        $form = $this->createForm(CategoryType::class, $category);
        // Récupère les données du formulaire
        $form->handleRequest($request);

        // Si le formulaire a été envoyé et que les données sont valides
        if ($form->isSubmitted() && $form->isValid()) {
            // Prépare les requêtes SQL de type add
            $entityManager->persist($category);
            // Envoie les données en BDD
            $entityManager->flush();

            // redirige vers la vue index
            return $this->redirectToRoute('admin_category_index', [], Response::HTTP_SEE_OTHER);
        }

        // Si le formulaire n'a pas été envoyé afficher une vue avec le formulaire
        return $this->renderForm('admin_category/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    // Ici on utilise le paramconverter pour récupérer l'id de la catégori actuel
    /**
     * @Route("/{id}", name="admin_category_show", methods={"GET"})
     */

     // Ici on utilise la classe Category car nous n'avons pas besoin d'afficher toutes les categories mais une seul en particulier
    public function show(Category $category): Response
    {
        return $this->render('admin_category/show.html.twig', [
            // Faire passer category permettra d'afficher chaque propriété de son entité dans la vue ex : category.id
            'category' => $category,
        ]);
    }

    // Rien de nouveau ici, cette fonction permet de modifier une catégorie
    /**
     * @Route("/{id}/edit", name="admin_category_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // notons ici que flush permet de faire une requête SQL alter table
            $entityManager->flush();

            return $this->redirectToRoute('admin_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_category_delete", methods={"POST"})
     */
    public function delete(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        // Ici une protection d'attaque CSRF est mise en place
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            // remove = SQL drop table
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
