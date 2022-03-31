<?php

namespace App\Repository;

use App\Entity\StockEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StockEntry|null find($id, $lockMode = null, $lockVersion = null)
 * @method StockEntry|null findOneBy(array $criteria, array $orderBy = null)
 * @method StockEntry[]    findAll()
 * @method StockEntry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StockEntry::class);
    }

    public function add(StockEntry $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function remove(StockEntry $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function getStockEntries(int $productId)
    {
        $query = $this->createQueryBuilder('s')
            ->where('s.product = :productId')
            ->setParameter('productId', $productId)
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ;
        return $query->getResult();
    }
}
