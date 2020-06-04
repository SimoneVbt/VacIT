<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use App\Entity\User;
use App\Entity\Vacature;
use App\Entity\Sollicitatie;

class UserController extends BaseController
/**
 * @Route("/user")
 */
{
    /**
     * @Route("/{id}/vacatures/sollicitaties", name="sollicitaties_werkgever")
     * @Template()
     */
    public function sollicitatiesWerkgever($id)
    {
        $userRep = $this->getDoctrine()->getRepository(User::class);
        $user = $userRep->find($id);

        return ['user' => $user];
    }

    /**
     * @Route("/{id}/vacatures", name="vacatures_werkgever")
     * @Template()
     */
    public function vacatures($id)
    {
        $userRep = $this->getDoctrine()->getRepository(User::class);
        $user = $userRep->find($id);

        return ['user' => $user];
    }

    



    /**
     * @Route("/{id}/sollicitaties", name="sollicitaties_kandidaat")
     * @Template()
     */
    public function sollicitaties($id)
    {
        $userRep = $this->getDoctrine()->getRepository(User::class);
        $user = $userRep->find($id);

        return ['user' => $user];
    }





    /**
     * @Route("/{id}/profiel", name="profiel")
     * @Template()
     */
    public function profiel($id)
    {
        $userRep = $this->getDoctrine()->getRepository(User::class);
        $user = $userRep->find($id);

        return ['user' => $user];
    }

    /**
     * @Route("/inloggen", name="inloggen")
     * @Template()
     */
    public function inloggen()
    {
        return [];
    }

    /**
     * @Route("/registreren", name="registreren")
     * @Template()
     */
    public function registreren()
    {
        return [];
    }
}
