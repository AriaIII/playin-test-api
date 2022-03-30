<?php

namespace App\Manager;

use App\Entity\DepositEntry;
use App\Repository\DepositEntryRepository;

class DepositEntryManager
{
    private DepositEntry $depositEntry;
    private DepositEntryRepository $depositEntryRepository;

    public function __construct(DepositEntryRepository $depositEntryRepository)
    {
        $this->depositEntryRepository = $depositEntryRepository;
    }

    public function soldQuantityUpdate(DepositEntry $depositEntry, int $quantity): DepositEntry
    {
        $depositEntry->setSoldQuantity($quantity);
        $this->depositEntryRepository->add($depositEntry);
        $this->depositEntry = $depositEntry;
        return $this->depositEntry;
    }
}
