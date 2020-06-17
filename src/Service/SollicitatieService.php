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


    public function saveSollicitatie($params)
    {
        $id = isset($params['id']) ? $params['id'] : NULL;
        $user = $this->us->findUser($params['user_id']);
        $vacature = $this->vs->findVacature($params['vacature_id']);
        $datum = new \Datetime(date_default_timezone_get());
        $uitnodiging = isset($params['uitnodiging']) ? $params['uitnodiging'] : NULL;
        $motivatie = isset($params['motivatie']) ? $params['motivatie'] : NULL;

        $params = array(
            "id" => $id,
            "user" => $user,
            "vacature" => $vacature,
            "datum" => $datum,
            "uitnodiging" => $uitnodiging,
            "motivatie" => $motivatie
        );
        return $this->rep->saveSollicitatie($params);
    }


    public function removeSollicitatie($id)
    {
        return $this->rep->removeSollicitatie($id);
    }

}