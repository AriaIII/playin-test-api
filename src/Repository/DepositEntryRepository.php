<?php

namespace App\Repository;

use App\Entity\DepositEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DepositEntry|null find($id, $lockMode = null, $lockVersion = null)
 * @method DepositEntry|null findOneBy(array $criteria, array $orderBy = null)
 * @method DepositEntry[]    findAll()
 * @method DepositEntry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepositEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DepositEntry::class);
    }

    public function add(DepositEntry $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function remove(DepositEntry $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function getDepositEntries(int $productId)
    {
        $query = $this->createQueryBuilder('d')
            ->where('d.product = :productId')
            ->setParameter('productId', $productId)
            ->orderBy('d.id', 'ASC')
            ->getQuery()
            ;
        return $query->getResult();
    }
}
