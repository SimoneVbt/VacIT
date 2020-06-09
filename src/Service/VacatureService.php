<?php

namespace App\Service;

use App\Entity\Vacature;
use Doctrine\ORM\EntityManagerInterface;

class VacatureService {

    private $em;
    private $rep;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
        $this->rep = $em->getRepository(Vacature::class);
    }


    public function findVacature($id) {
        return $this->rep->findVacature($id);
    }

    public function getAllVacaturesByDate() {
        return $this->rep->getAllVacaturesByDate();
    }
}