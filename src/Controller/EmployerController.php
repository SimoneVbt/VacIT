<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Service\UserService;
use App\Service\VacatureService;

/**
 * @Route("/werkgever")
 */
class EmployerController extends BaseController
{

    /**
     * @Route("/{id}/vacatures/sollicitaties", name="alle_sollicitaties_werkgever")
     * @Template()
     */
    public function alleSollicitaties(UserService $us, $id)
    {
        $user = $us->findUser($id);

        if ($this->checkUser($user, $id)) {
            return ['user' => $user];
        }
    }


    /**
     * @Route("/{user_id}/vacatures/{vacature_id}/sollicitaties", name="sollicitaties_werkgever")
     * @Template()
     */
    public function sollicitaties(UserService $us,
                                  VacatureService $vs,
                                  $user_id, $vacature_id)
    {
        $user = $us->findUser($user_id);
        $vacature = $vs->findVacature($vacature_id);

        if ($this->checkUser($user, $user_id)) {
            return ["user" => $user, "vacature" => $vacature];
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
