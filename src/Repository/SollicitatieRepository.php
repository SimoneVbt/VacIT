<?php

namespace App\Repository;

use App\Entity\Sollicitatie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SollicitatieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sollicitatie::class);
    }


    public function findSollicitatie($id)
    {
        return $this->find($id);
    }


    public function checkSollicitatie($user_id, $vacature_id)
    {
        $check = $this->findBy(
            ["user" => $user_id,
            "vacature" => $vacature_id]
        );
        return $result = $check ? true : false;
    }


    public function saveSollicitatie($params)
    {
        if (isset($params['id'])) {
            $sollicitatie = $this->find($params['id']);
        } else {
            $sollicitatie = new Sollicitatie();
            $sollicitatie->setDatum($params['datum']);
        }

        $sollicitatie->setUser($params['user']);
        $sollicitatie->setVacature($params['vacature']);
        $sollicitatie->setMotivatie($params['motivatie']);
        
        if (isset($params['uitnodiging'])) {
            $sollicitatie->setUitnodiging($params['uitnodiging']);
            $sollicitatie->setDatumUitgenodigd($params['datum']);
        }

        $em = $this->getEntityManager();
        $em->persist($sollicitatie);
        $em->flush();

        return $sollicitatie;
    }


    public function removeSollicitatie($id)
    {
        $sollicitatie = $this->find($id);
        if ($sollicitatie) {
            $em = $this->getEntityManager();
            $em->remove($sollicitatie);
            $em->flush();
            return true;
        }
        return false;
    }
}
