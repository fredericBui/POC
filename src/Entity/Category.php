<?php

// Chaque entité représente une table de la base de donnée

namespace App\Entity;

use App\Repository\CategoryRepository;
// Utilisation de doctrine pour généré les requêtes SQL dans la migration
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    // Ci dessous leur colonne
    // J'ai vu que @ est un opérateur qui permet en php de masquer les erreurs si il y en a, correct ?
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    // Ici on créer des fonctions permettant de servir ou modifier les valeurs des propriétés de l'objet créé dans le controller
    public function getId(): ?int
    {
        // sert
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        // modifier avec la valeur en paramètre
        $this->name = $name;

        return $this;
    }

    // Il est nécessaire d'utiliser cette fonction pour forcer le nom de la catégorie à être au format chaîne de caractère
    // On utilse cette fonction magique dans le cas où l'entité à un lien de parenté avec une autre, c'est à dire quel est lié à une autre table
    // Et que lorsqu'elle est appellé dans un formulaire elle affiche tous ses choix possible
    public function __toString()
    {
        return $this->name;
    }
}
