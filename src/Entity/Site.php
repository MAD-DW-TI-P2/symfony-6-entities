<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SiteRepository::class)]
#[ApiResource]
class Site
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 556)]
    private ?string $url = null;

    #[ORM\OneToMany(targetEntity: Query::class, mappedBy: 'site')]
    private Collection $tool;

    public function __construct()
    {
        $this->tool = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return Collection<int, Query>
     */
    public function getTool(): Collection
    {
        return $this->tool;
    }

    public function addTool(Query $tool): static
    {
        if (!$this->tool->contains($tool)) {
            $this->tool->add($tool);
            $tool->setSite($this);
        }

        return $this;
    }

    public function removeTool(Query $tool): static
    {
        if ($this->tool->removeElement($tool)) {
            // set the owning side to null (unless already changed)
            if ($tool->getSite() === $this) {
                $tool->setSite(null);
            }
        }

        return $this;
    }
}
