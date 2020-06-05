<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Entity\User;

class CandidateController extends BaseController
/**
 * @Route("/kandidaat")
 */
{
    /**
    * @Route("/{id}/sollicitaties", name="sollicitaties_kandidaat")
    * @Template()
    */
   public function sollicitaties($id)
   {
       $userRep = $this->getDoctrine()->getRepository(User::class);
       $user = $userRep->find($id);

       return ['user' => $user];
   }
}
