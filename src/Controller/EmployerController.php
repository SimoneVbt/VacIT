<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Service\UserService;

/**
 * @Route("/werkgever")
 */
class EmployerController extends BaseController
{
    /**
     * @Route("/{id}/vacatures/sollicitaties", name="sollicitaties_werkgever")
     * @Template()
     */
    public function sollicitaties(UserService $us, $id)
    {
        $user = $us->findUser($id);

        if ($this->checkUser($user, $id)) {
            return ['user' => $user];
        }
    }

    /**
     * @Route("/{id}/vacatures", name="vacatures_werkgever")
     * @Template()
     */
    public function vacatures(UserService $us, $id)
    {
        $user = $us->findUser($id);

        if ($this->checkUser($user, $id)) {
            return ['user' => $user];
        }
    }

}
