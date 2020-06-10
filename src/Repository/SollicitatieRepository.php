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


    public function saveSollicitatie($params)
    {
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
