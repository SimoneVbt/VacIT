<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService {

    private $em;
    private $um;
    private $encoder;
    private $rep;

    public function __construct(EntityManagerInterface $em,
                                UserManagerInterface $um,
                                UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em;
        $this->um = $um;
        $this->encoder = $encoder;
        $this->rep = $em->getRepository(User::class);
    }
    

    public function findUser($id) {
        return $this->rep->findUser($id);
    }


    public function saveUser($params)
    {
        if (isset($params["geboortedatum"])) {
            $params["geboortedatum"] = new \DateTime($params["geboortedatum"]);
        }
        return $this->rep->saveUser($params);
    }
}