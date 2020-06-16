<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use App\Service\UserService;
use App\Service\VacatureService;

/**
 * @Route("/werkgever")
 */
class EmployerController extends BaseController
{
    private $us;
    private $vs;

    public function __construct(UserService $us,
                                VacatureService $vs)
    {
        $this->us = $us;
        $this->vs = $vs;
    }

    
    /**
     * @Route("/{emp_id}/profiel", name="bekijk_werkgever")
     * @Template()
     */
    public function bekijkWerkgever($emp_id)
    {
        $emp = $this->us->findUser($emp_id);
        return ['user' => $emp];
    }


    /**
     * @Route("/{user_id}/vacatures/{vacature_id}/sollicitaties", name="sollicitaties_werkgever")
     * @Template()
     */
    public function sollicitaties($user_id, $vacature_id)
    {
        $user = $this->us->findUser($user_id);
        if ($this->checkUser($user, $user_id)) {

            $vacature = $this->vs->findVacature($vacature_id);
            return ["user" => $user, "vacature" => $vacature];
        }
    }
    

    /**
     * @Route("/{user_id}/vacatures/sollicitaties", name="alle_sollicitaties_werkgever")
     * @Template()
     */
    public function alleSollicitaties($user_id)
    {
        $user = $this->us->findUser($user_id);
        if ($this->checkUser($user, $user_id)) {
            return ['user' => $user];
        }
    }


    /**
     * @Route("/{user_id}/vacatures/bewerk/{vacature_id}", name="bewerk_vacature")
     * @Template()
     */
    public function bewerkVacature($user_id, $vacature_id, ParameterBagInterface $param)
    {
        $user = $this->us->findUser($user_id);
        if ($this->checkUser($user, $user_id)) {

            $vacature = $this->vs->findVacature($vacature_id);
            $iconsDir = $param->get('webDir').'/assets/img/icons/';
            $icons = scandir($iconsDir);

            return [
                "user" => $user,
                "vacature" => $vacature, 
                "icons" => $icons
            ];
        }
    }

    
    /**
     * @Route("/{user_id}/vacatures/verwijder", name="verwijder_vacature")
     * @Template()
     */

    public function verwijderVacature($user_id)
    {
        $user = $this->us->findUser($user_id);
        if ($this->checkUser($user, $user_id)) {
            return ['user' => $user];
        }
    }

    
    /**
     * @Route("/{user_id}/vacatures/nieuw", name="nieuwe_vacature")
     * @Template()
     */
    public function nieuweVacature($user_id, ParameterBagInterface $param)
    {
        $user = $this->us->findUser($user_id);
        if ($this->checkUser($user, $user_id)) {

            $iconsDir = $param->get('webDir').'/assets/img/icons/';
            $icons = scandir($iconsDir);
            return ['user' => $user, "icons" => $icons];
        }
    }


    /**
     * @Route("/{user_id}/vacatures", name="vacatures_werkgever")
     * @Template()
     */
    public function vacatures($user_id)
    {
        $user = $this->us->findUser($user_id);
        if ($this->checkUser($user, $user_id)) {
            return ['user' => $user];
        }
    }

}
