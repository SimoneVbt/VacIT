<?php

namespace App\Service;

use App\Entity\Vacature;
use Doctrine\ORM\EntityManagerInterface;

class VacatureService {

    private $em;
    private $rep;
    private $us;

    public function __construct(EntityManagerInterface $em,
                                UserService $us) {
        $this->em = $em;
        $this->rep = $em->getRepository(Vacature::class);
        $this->us = $us;
    }


    public function findVacature($id)
    {
        return $this->rep->findVacature($id);
    }


    public function getAllVacaturesByDate()
    {
        return $this->rep->getAllVacaturesByDate();
    }

    
    public function removeVacature($id)
    {
        return $this->rep->removeVacature($id);
    }


    public function saveVacature($params)
    {
        $params["user"] = $this->us->findUser($params['user_id']);
        date_default_timezone_set('Europe/Amsterdam');
        $params["datum"] = new \Datetime(date_default_timezone_get());

        return $this->rep->saveVacature($params);
    }
}