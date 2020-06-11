<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Service\UserService;
use App\Service\VacatureService;
use App\Service\SollicitatieService;

/**
 * @Route("/werkgever")
 */
class EmployerController extends BaseController
{
    private $us;
    private $vs;
    private $ss;

    public function __construct(UserService $us,
                                SollicitatieService $ss,
                                VacatureService $vs)
    {
        $this->us = $us;
        $this->ss = $ss;
        $this->vs = $vs;
    }


    /**
     * @Route("/{user_id}/vacatures/{vacature_id}/sollicitaties/uitnodiging",
     * name="ajax_uitnodiging")
     */
    public function uitnodiging(Request $request,
                                $user_id, $vacature_id)
    {
        $user = $this->us->findUser($user_id);
        if ($this->checkUser($user, $user_id)) {

            $params = $request->request->all();
            $result = $this->ss->saveSollicitatie($params);
            return new Response("gelukt");
            
        }
    }


    /**
     * @Route("/{user_id}/vacatures/{vacature_id}/sollicitaties", name="sollicitaties_werkgever")
     * @Template()
     */
    public function sollicitaties($user_id, $vacature_id)
    {
        $user = $this->us->findUser($user_id);
        $vacature = $this->vs->findVacature($vacature_id);

        if ($this->checkUser($user, $user_id)) {
            return ["user" => $user, "vacature" => $vacature];
        }
    }

    

    /**
     * @Route("/{id}/vacatures/sollicitaties", name="alle_sollicitaties_werkgever")
     * @Template()
     */
    public function alleSollicitaties($id)
    {
        $user = $this->us->findUser($id);

        if ($this->checkUser($user, $id)) {
            return ['user' => $user];
        }
    }


    /**
     * @Route("/{id}/vacatures", name="vacatures_werkgever")
     * @Template()
     */
    public function vacatures($id)
    {
        $user = $this->us->findUser($id);

        if ($this->checkUser($user, $id)) {
            return ['user' => $user];
        }
    }

}
