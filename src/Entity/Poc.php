<?php

namespace App\Entity;

use App\Repository\PocRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PocRepository::class)
 */
class Poc
{
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

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imageFilename;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $githubLink;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $liveDemoLink;

    /**
     * @ORM\Column(type="text")
     */
    private $keywords;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $author;

    /**
     * @ORM\ManyToMany(targetEntity=Language::class)
     */
    private $languages;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class)
     */
    private $categories;

    public function __construct()
    {
        $this->languages = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImageFilename(): ?string
    {
        return $this->imageFilename;
    }

    public function setImageFilename(string $imageFilename): self
    {
        $this->imageFilename = $imageFilename;

        return $this;
    }

    public function getGithubLink(): ?string
    {
        return $this->githubLink;
    }

    public function setGithubLink(string $githubLink): self
    {
        $this->githubLink = $githubLink;

        return $this;
    }

    public function getLiveDemoLink(): ?string
    {
        return $this->liveDemoLink;
    }

    public function setLiveDemoLink(?string $liveDemoLink): self
    {
        $this->liveDemoLink = $liveDemoLink;

        return $this;
    }

    public function getKeywords(): ?string
    {
        return $this->keywords;
    }

    public function setKeywords(string $keywords): self
    {
        $this->keywords = $keywords;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection|Language[]
     */
    public function getLanguages(): Collection
    {
        return $this->languages;
    }

    public function addLanguage(Language $language): self
    {
        if (!$this->languages->contains($language)) {
            $this->languages[] = $language;
        }

        return $this;
    }

    public function removeLanguage(Language $language): self
    {
        $this->languages->removeElement($language);

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }
}
