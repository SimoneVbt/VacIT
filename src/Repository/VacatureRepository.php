<?php

namespace App\Repository;

use App\Entity\Vacature;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class VacatureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vacature::class);
    }


    public function findVacature($id) {
        return $this->find($id);
    }


    public function getAllVacaturesByDate() 
    {
        $vacatures = $this->createQueryBuilder('v')
                    ->orderBy('v.plaatsingsdatum', 'DESC')
                    ->getQuery()
                    ->getResult();

        return $vacatures;
    }


    public function saveVacature($params) {
        if (isset($params['id'])) {
            $vacature = $this->find($params['id']);
            $vacature->setDatumBijgewerkt($params["datum"]);
        } else {
            $vacature = new Vacature();
            $vacature->setPlaatsingsdatum($params["datum"]);
        }

        $vacature->setUser($params['user']);
        $vacature->setVacaturetitel($params['vacaturetitel']);
        $vacature->setVacaturetekst($params['vacaturetekst']);
        $vacature->setWerkniveau($params['werkniveau']);
        $vacature->setStandplaats($params['standplaats']);

        $vacature->setAfbeelding(isset($params['afbeelding']) ? $params['afbeelding'] : null);

        $em = $this->getEntityManager();
        $em->persist($vacature);
        $em->flush();

        return $vacature;
    }


    public function removeVacature($id) {
        $vacature = $this->find($id);
        if($vacature) {
            $em = $this->getEntityManager();
            $em->remove($vacature);
            $em->flush();
            return true;
        }
        return false;
    }
}
