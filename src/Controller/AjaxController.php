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
 * @Route("/ajax")
 */

class AjaxController extends BaseController
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
     * @Route("/{user_id}/nieuwe_vacature", name="ajax_vacature")
     */
    public function nieuweVacature(Request $request, $user_id)
    {
        $params = $request->request->all();
        $result = $this->vs->saveVacature($params);
        return new Response("De vacature is geplaatst!");
    }
    

    /**
     * @Route("/{user_id}/{vacature_id}/verstuur_uitnodiging", name="ajax_uitnodiging")
     */
    public function uitnodiging(Request $request, $user_id, $vacature_id)
    {
        $user = $this->us->findUser($user_id);
        if ($this->checkUser($user, $user_id)) {

            $params = $request->request->all();
            $result = $this->ss->saveSollicitatie($params);
            return new Response("De uitnodiging/afwijzing is verstuurd.");
            
        }
    }

    
    /**
     * @Route("/{user_id}/bewerk_profiel", name="ajax_profiel")
     */
    public function bewerkProfiel(Request $request, $user_id)
    {
        $user = $this->us->findUser($user_id);
        if ($this->checkUser($user, $user_id)) {

            $params = $request->request->all();
            $result = $this->us->saveUser($params);
            return new Response("Het profiel is bijgewerkt.");
            
        }
    }
}
