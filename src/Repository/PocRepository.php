<?php

namespace App\Repository;

use App\Entity\Poc;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Poc|null find($id, $lockMode = null, $lockVersion = null)
 * @method Poc|null findOneBy(array $criteria, array $orderBy = null)
 * @method Poc[]    findAll()
 * @method Poc[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PocRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Poc::class);
    }

    // /**
    //  * @return Poc[] Returns an array of Poc objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Poc
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
