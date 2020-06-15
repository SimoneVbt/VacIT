<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use App\Service\UserService;
use App\Service\VacatureService;

/**
 * @Route("/kandidaat")
 */
class CandidateController extends BaseController
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
    * @Route("/{user_id}/sollicitaties", name="sollicitaties_kandidaat")
    * @Template()
    */
   public function sollicitaties($user_id)
   {
        $user = $this->us->findUser($user_id);

        if ($this->checkUser($user, $user_id)) {
            return ['user' => $user];
        }
       
   }


    /**
     * @Route("/{user_id}/nieuwe_sollicitatie/{vacature_id}", name="nieuwe_sollicitatie")
     * @Template()
     */

    public function nieuweSollicitatie($user_id, $vacature_id)
    {
        $user = $this->us->findUser($user_id);
        if ($this->checkUser($user, $user_id)) {

            $vacature = $this->vs->findVacature($vacature_id);
            return ['user' => $user, 'vacature' => $vacature];
        }   
    }
}
