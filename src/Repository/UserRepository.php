<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserRepository extends ServiceEntityRepository
{
    private $em;
    private $um;
    private $encoder;

    public function __construct(ManagerRegistry $registry,
                                EntityManagerInterface $em,
                                UserManagerInterface $um,
                                UserPasswordEncoderInterface $encoder)
    {
        parent::__construct($registry, User::class);
        $this->em = $em;
        $this->um = $um;
        $this->encoder = $encoder;
    }


    public function findUser($id) {
        return $this->find($id);
    }


    public function saveUser($params) {
        $u = $this->um->findUserByEmail($params['email']);

        if (!$u) {
            $user = $this->um->createUser();
            $user->setUsername($params['email']);
            $user->setEmail($params['email']);
            $user->setEnabled(true);
            $user->setRoles($params['rollen']);

            $password = $this->encoder->encodePassword($user, $params['wachtwoord']);
            $user->setPassword($password);
            
            //oppassen: als het bestaat, meegeven met $params, anders wordt het null
            $user->setNaam(isset($params["naam"]) ? $params["naam"] : null);
            $user->setVoornaam(isset($params["voornaam"]) ? $params["voornaam"] : null);
            $user->setGeboortedatum(isset($params["geboortedatum"]) ? $params["geboortedatum"] : null);
            $user->setTelefoonnummer(isset($params["telefoonnummer"]) ? $params["telefoonnummer"] : null);
            $user->setAdres(isset($params["adres"]) ? $params["adres"] : null);
            $user->setPostcode(isset($params["postcode"]) ? $params["postcode"] : null);
            $user->setPlaats(isset($params["plaats"]) ? $params["plaats"] : null);
            $user->setAfbeelding(isset($params["afbeelding"]) ? $params["afbeelding"] : null);
            $user->setMotivatie(isset($params["motivatie"]) ? $params["motivatie"] : null);
            $user->setCv(isset($params["cv"]) ? $params["cv"] : null);

            $this->um->updateUser($user);
            return $user;

        } else {
            return ("Deze gebruiker bestaat al.");
        }
        
    }
    

    public function removeUser($id) {
        $user = $this->find($id);
        if($user) {
            $this->em->remove($user);
            $this->em->flush();
            return true;
        }
        return false;
    }
}
