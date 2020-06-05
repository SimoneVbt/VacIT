<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Entity\User;

class EmployerController extends BaseController
/**
 * @Route("/werkgever")
 */
{
    /**
     * @Route("/{id}/vacatures/sollicitaties", name="sollicitaties_werkgever")
     * @Template()
     */
    public function sollicitaties($id)
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

}
