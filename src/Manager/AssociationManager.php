<?php

namespace App\Manager;

use App\Entity\Association;
use App\Repository\AssociationRepository;
use Doctrine\ORM\EntityManagerInterface;

class AssociationManager
{
    private $entityManager;
    private $associationRepository;

    public function __construct(EntityManagerInterface $entityManager, AssociationRepository $associationRepository)
    {
        $this->entityManager = $entityManager;
        $this->associationRepository = $associationRepository;
    }

    public function create($margin, $orderEntryId, $sale, $origin)
    {
        $association = new Association();
        $association->setMargin($margin)
            ->setOrderEntry($orderEntryId)
            ->setSale($sale)
            ->setProductOrigin($origin)
        ;
    }

    public function depositMarginCaculate($percentage, $sellPrice, $quantity)
    {
        return $quantity * ($sellPrice * (1 - $percentage/100));
    }

    public function stockMarginCalculate($buyPrice, $sellPrice, $quantity)
    {
        return $quantity * ($sellPrice - $buyPrice);
    }
}
