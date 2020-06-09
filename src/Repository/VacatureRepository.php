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
        } else {
            $vacature = new Vacature();
        }

        $vacature->setUser($params['user']); //moet user-object zijn, niet id

        date_default_timezone_set('Europe/Amsterdam');
        $vacature->setPlaatsingsdatum(isset($params['datum']) ? $params['datum'] : new \Datetime (date_default_timezone_get()) );
        $vacature->setPlaatsingsdatum(isset($params['datum_bijgewerkt']) ? new \Datetime (date_default_timezone_get()) : null);

        $vacature->setVacaturetitel($params['titel']);
        $vacature->setVacaturetekst($params['tekst']);
        $vacature->setAfbeelding(isset($params['afbeelding']) ? $params['afbeelding'] : null);
        $vacature->setWerkniveau($params['niveau']);

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
