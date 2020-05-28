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


    public function saveSollicitatie($params) {
        if (isset($params['id'])) { //afdoende controle voor dubbele sollicitaties?
            $sollicitatie = $this->find($params['id']);
        } else {
            $sollicitatie = new Sollicitatie();
        }

        $sollicitatie->setUser($params['user']);
        $sollicitatie->setVacature($params['vacature']);

        $sollicitatie->setUitnodiging(isset($params['uitnodiging']) ? $params['uitnodiging'] : false);
        $sollicitatie->setDatumUitgenodigd(isset($params['datum_uitgenodigd']) ? $params['datum_uitgenodigd'] : null);

        $em = $this->getEntityManager();
        $em->persist($sollicitatie);
        $em->flush();

        return $sollicitatie;
    }

    public function removeSollicitatie($id) {
        $sollicitatie = $this->find($id);
        if($sollicitatie) {
            $em = $this->getEntityManager();
            $em->remove($sollicitatie);
            $em->flush();
            return true;
        }
        return false;
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
