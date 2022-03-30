<?php

namespace App\Entity;


use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AssociationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssociationRepository::class)]
#[ORM\Table(name: 't_assoc')]
#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: ['get']
)]
class Association
{
    public const STOCK = 'O';
    public const DEPOSIT = 'N';
    public const VIRTUAL = 'V';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_assoc', type: 'integer')]
    private int $id;

    #[ORM\Column(name: 'vendeur', type: 'string', columnDefinition: "ENUM('O', 'N', 'V')")]
    private string $sale;

    #[ORM\OneToOne(targetEntity: OrderEntry::class)]
    #[ORM\JoinColumn(name: 'id_detail', referencedColumnName: 'id_detail')]
    #[ORM\Column(name: 'id_detail', type: 'integer')]
    private int $orderEntry;

    #[ORM\Column(name: 'id_detail_stock', type: 'integer', nullable: true)]
    private int $productOrigin;

    #[ORM\Column(name: 'margin', type: 'float')]
    private float $margin;

    public function getId(): int
    {
        return $this->id;
    }

    public function getSale(): string
    {
        return $this->sale;
    }

    public function setSale(string $sale): self
    {
        $this->sale = $sale;
        return $this;
    }

    public function getOrderEntry(): int
    {
        return $this->orderEntry;
    }

    public function setOrderEntry(int $orderEntry): self
    {
        $this->orderEntry = $orderEntry;
        return $this;
    }

    public function getProductOrigin(): int
    {
        return $this->productOrigin;
    }

    public function setProductOrigin(int $productOrigin): self
    {
        $this->productOrigin = $productOrigin;
        return $this;
    }

    public function getMargin(): float
    {
        return $this->margin;
    }

    public function setMargin(float $margin): self
    {
        $this->margin = $margin;
        return $this;
    }

}
