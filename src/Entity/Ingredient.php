<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IngredientRepository::class)
 */
class Ingredient
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Recettes::class, inversedBy="ingredients")
     */
    private $recette;

    public function __construct()
    {
        $this->recette = new ArrayCollection();
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

    /**
     * @return Collection|Recettes[]
     */
    public function getRecette(): Collection
    {
        return $this->recette;
    }

    public function addRecette(Recettes $recette): self
    {
        if (!$this->recette->contains($recette)) {
            $this->recette[] = $recette;
        }

        return $this;
    }

    public function removeRecette(Recettes $recette): self
    {
        if ($this->recette->contains($recette)) {
            $this->recette->removeElement($recette);
        }

        return $this;
    }
}
