<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Service\UserService;

/**
 * @Route("/kandidaat")
 */
class CandidateController extends BaseController
{
    /**
    * @Route("/{id}/sollicitaties", name="sollicitaties_kandidaat")
    * @Template()
    */
   public function sollicitaties(UserService $us, $id)
   {
        $user = $us->findUser($id);

        if ($this->checkUser($user, $id)) {
            return ['user' => $user];
        }
       
   }
}
