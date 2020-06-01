<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use App\Entity\Vacature;

class VacatureoverzichtController extends BaseController
/**
 * @Route("/vacatures", name="vacatures")
 */
{
    /**
     * @Route("/", name="vacatureoverzicht")
     * @Template()
     */
    public function index()
    {
        $vacRep = $this->getDoctrine()->getRepository(Vacature::class);
        $vacatures = $vacRep->getAllVacaturesByDate();

        return [
            'vacatures' => $vacatures,
        ];
    }
}
