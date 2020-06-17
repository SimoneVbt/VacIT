<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use App\Service\UserService;
use App\Service\VacatureService;
use App\Service\SollicitatieService;

/**
 * @Route("/kandidaat")
 */
class CandidateController extends BaseController
{
    private $us;
    private $vs;
    private $ss;

    public function __construct(UserService $us,
                                VacatureService $vs,
                                SollicitatieService $ss)
    {
        $this->us = $us;
        $this->vs = $vs;
        $this->ss = $ss;
    }


    /**
     * @Route("/{cand_id}/motivatie/{emp_id}/{sollicitatie_id}", name="motivatie_kandidaat")
     * @Template()
     */
    public function motivatie($cand_id, $emp_id, $sollicitatie_id)
    {
        $cand = $this->us->findUser($cand_id);
        $emp = $this->us->findUser($emp_id);

        if ($this->checkUser($cand, $cand_id, true) || $this->checkUser($emp, $emp_id, true)) {

            $soll = $this->ss->findSollicitatie($sollicitatie_id);
            return ['soll' => $soll];

        } else {
            throw new AccessDeniedException ('U heeft geen toegang tot deze pagina.');
        }
    }


    /**
     * @Route("/{cand_id}/profiel", name="bekijk_kandidaat")
     * @Template()
     */
    public function bekijkKandidaat($cand_id)
    {
        $cand = $this->us->findUser($cand_id);
        return ['user' => $cand];
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
