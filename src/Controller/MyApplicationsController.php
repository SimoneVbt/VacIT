<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
// use App\Entity\User;
// use App\Entity\Vacature;
use App\Entity\Sollicitatie;

class MyApplicationsController extends BaseController
/**
 * @Route("/my_applications")
 */
{
    /**
     * @Route("/", name="my_applications")
     * @Template()
     */
    public function index()
    {
        $sollRep = $this->getDoctrine()->getRepository(Sollicitatie::class);
        $sollicitaties = $sollRep/*->functie*/ ;

        return [
            'data' => $sollicitaties,
        ];
    }
}
