<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\ProductCollectionController;
use App\Controller\ProductController;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource(
    collectionOperations: [ "get",
        "get_by_locale" => [
            "method" => "GET",
            "path" => "/products/all/{localeCode}",
            "controller" => ProductCollectionController::class,
            "read" => false,
            "openapi_context" => [
                "summary" => "Retrieves the collection of Product resources, including full price with VAT for requested locale/country",
                "description" => "Retrieves a Product resource, including full price with VAT for requested locale/country",
                "parameters" => [
                    [
                        "name" => "localeCode",
                        "in" => "path",
                        "description" => "The ISO code of needed locale",
                        "type" => "string",
                        "required" => true,
                        "example"=> "eng"
                    ]
                ],
            ],

        ], ],
    itemOperations: [
        "get",
        "patch",
        "delete",
        "put",
        "get_by_locale" => [
            "method" => "GET",
            "path" => "/products/{id}/{localeCode}",
            "controller" => ProductController::class,
            "read" => false,
            "openapi_context" => [
                "summary" => "Retrieves a Product resource, including full price with VAT for requested locale/country",
                "description" => "Retrieves a Product resource, including full price with VAT for requested locale/country",
                "parameters" => [
                    [
                        "name" => "localeCode",
                        "in" => "path",
                        "description" => "The ISO code of needed locale",
                        "type" => "string",
                        "required" => true,
                        "example"=> "eng"
                    ]
                ],
            ],

        ],
    ]
)]
class Product
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'float')]
    private $price;

    #[ORM\Column(type: 'string', length: 255)]
    private $type;

    #[ORM\ManyToMany(targetEntity: Vat::class, inversedBy: 'products')]
    private $vat;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

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
        }

        return $this;
    }

    public function removeVat(Vat $vat): self
    {
        $this->vat->removeElement($vat);

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
