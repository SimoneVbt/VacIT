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
            $user->setRoles($params['roles']);
            $user->setEnabled(true);

            $password = $this->encoder->encodePassword($user, $params['wachtwoord']);
            $user->setPassword($password);

        } else {
            $user = $u;
        }
            $user->setEmail($params['email']);
            $user->setNaam(isset($params["naam"]) ? $params["naam"] : null);
            $user->setVoornaam(isset($params["voornaam"]) ? $params["voornaam"] : null);
            $user->setGeboortedatum(isset($params["geboortedatum"]) ? $params["geboortedatum"] : null);
            $user->setTelefoonnummer(isset($params["telefoonnummer"]) ? $params["telefoonnummer"] : null);
            $user->setAdres(isset($params["adres"]) ? $params["adres"] : null);
            $user->setPostcode(isset($params["postcode"]) ? $params["postcode"] : null);
            $user->setPlaats(isset($params["plaats"]) ? $params["plaats"] : null);
            $user->setTekst(isset($params["tekst"]) ? $params["tekst"] : null);

            if (isset($params['afbeelding'])) {
                $user->setAfbeelding($params['afbeelding']);
            }
            if (isset($params['cv'])) {
                $user->setCv($params['cv']);
            }

            $this->um->updateUser($user);
            return $user;
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
