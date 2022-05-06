<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
#[ApiResource]
class   Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: Vat::class, orphanRemoval: true)]
    private $vat;

    #[ORM\OneToOne(inversedBy: 'country', targetEntity: Locale::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $locale;

    public function __construct()
    {
        $this->vat = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, Vat>
     */
    public function getVat(): Collection
    {
        return $this->vat;
    }

    public function addVat(Vat $vat): self
    {
        if (!$this->vat->contains($vat)) {
            $this->vat[] = $vat;
            $vat->setCountry($this);
        }

        return $this;
    }

    public function removeVat(Vat $vat): self
    {
        if ($this->vat->removeElement($vat)) {
            // set the owning side to null (unless already changed)
            if ($vat->getCountry() === $this) {
                $vat->setCountry(null);
            }
        }

        return $this;
    }

    public function getLocale(): ?Locale
    {
        return $this->locale;
    }

    public function setLocale(Locale $locale): self
    {
        $this->locale = $locale;

        return $this;
    }
}
