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
        $vacatureRepository = $this->getDoctrine()->getRepository(Vacature::class);
        $vacatures = $vacatureRepository->getAllVacaturesByDate();

        return [
            'data' => $vacatures,
        ];
    }

    /**
     * @Route("/vacatures",  name="vacatureoverzicht")
     * @Template()
     */
    public function vacatures()
    {
        $vacatureRepository = $this->getDoctrine()->getRepository(Vacature::class);
        $vacatures = $vacatureRepository->getAllVacaturesByDate();
        
        return [
            'data' => $vacatures,
        ];
    }
}
