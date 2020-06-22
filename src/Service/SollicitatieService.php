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


    public function checkSollicitatie($user_id, $vacature_id)
    {
        return $this->rep->checkSollicitatie($user_id, $vacature_id);
    }


    public function saveSollicitatie($params)
    {
        $params["user"] = $this->us->findUser($params['user_id']);
        $params["vacature"] = $this->vs->findVacature($params['vacature_id']);
        $params["datum"] = new \Datetime(date_default_timezone_get());

        return $this->rep->saveSollicitatie($params);
    }


    public function removeSollicitatie($id)
    {
        return $this->rep->removeSollicitatie($id);
    }

}