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