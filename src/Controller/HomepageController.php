<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Entity\User;
use App\Entity\Vacature;
use App\Entity\Sollicitatie;

class HomepageController extends BaseController
/**
 * @Route("/")
 */
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function index()
    {
        $vacRep = $this->getDoctrine()->getRepository(Vacature::class);
        $vacatures = $vacRep->findall();

        return [
            'data' => $vacatures,
        ];
    }
}
