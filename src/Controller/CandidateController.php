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
    * @Route("/{id}/sollicitaties", name="sollicitaties_kandidaat")
    * @Template()
    */
   public function sollicitaties($id)
   {
        $user = $this->us->findUser($id);

        if ($this->checkUser($user, $id)) {
            return ['user' => $user];
        }
       
   }


    /**
     * @Route("/{id}/solliciteer/{vacature_id}", name="solliciteer")
     * @Template()
     */

    public function solliciteer($id, $vacature_id)
    {
        $user = $this->us->findUser($id);
        if ($this->checkUser($user, $id)) {

            $vacature = $this->vs->findVacature($vacature_id);
            return ['user' => $user, 'vacature' => $vacature];
        }   
        
        // /** 
        //  * @Route("/{id}/solliciteer/{user_id}/go", name="ajax_solliciteer")
        // */
        // public function solliciteerAjax (Request $request, $id)
        // {
    
        // }
    }
}
