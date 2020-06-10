<?php

namespace App\Service;

use App\Entity\Sollicitatie;
use Doctrine\ORM\EntityManagerInterface;

class SollicitatieService {

    private $em;
    private $rep;
    private $us;
    private $vs;

    public function __construct(EntityManagerInterface $em,
                                UserService $us,
                                VacatureService $vs)
    {
        $this->em = $em;
        $this->rep = $em->getRepository(Sollicitatie::class);
        $this->us = $us;
        $this->vs = $vs;
    }


    public function findSollicitatie($id)
    {
        return $this->rep->findSollicitatie($id);
    }


    public function saveSollicitatie($vacId, $userId)
    {
        $user = $us->findUser($userId);
        $vac = $vs->findVacature($vacId);
        $params = ["user" => $user, "vacature" => $vac];
        
        return $this->rep->saveSollicitatie($params);
    }


    public function removeSollicitatie($id)
    {
        return $this->rep->removeSollicitatie($id);
    }

}