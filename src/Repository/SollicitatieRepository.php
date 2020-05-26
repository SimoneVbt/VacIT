<?php

namespace App\Repository;

use App\Entity\Sollicitatie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sollicitatie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sollicitatie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sollicitatie[]    findAll()
 * @method Sollicitatie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SollicitatieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sollicitatie::class);
    }

    // /**
    //  * @return Sollicitatie[] Returns an array of Sollicitatie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sollicitatie
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
