<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateUserService {
    private $em;
    private $um;
    private $encoder;

    public function __construct(EntityManagerInterface $em,
                                UserManagerInterface $um,
                                UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em;
        $this->um = $um;
        $this->encoder = $encoder;
    }

    public function createUser($params)
    {
        $u = $this->um->findUserByEmail($params['email']);
        if (!$u) {
            $user = $this->um->createUser();
            $user->setUsername($params['email']);
            $user->setEmail($params['email']);
            $user->setEnabled(true);

            $password = $this->encoder->encodePassword($user, $params['password']);
            $user->setPassword($password);

            $this->um->updateUser($user);
            return $user;

        } else {
            return ("Deze gebruiker bestaat al.");
        }
    }
}