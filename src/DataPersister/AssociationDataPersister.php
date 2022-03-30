<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Association;

class AssociationDataPersister implements ContextAwareDataPersisterInterface
{

    /**
     * @inheritDoc
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Association;
    }

    /**
     * @inheritDoc
     */
    public function persist($data, array $context = [])
    {
        // TODO: Implement persist() method.
    }

    /**
     * @inheritDoc
     */
    public function remove($data, array $context = [])
    {
        // TODO: Implement remove() method.
    }
}
