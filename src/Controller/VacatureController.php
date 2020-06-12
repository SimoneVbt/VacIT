<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\VacatureService;

/**
 * @Route("/vacature")
 */
class VacatureController extends BaseController
{
    private $vs;

    public function __construct(VacatureService $vs)
    {
        $this->vs = $vs;
    }


    /**
     * @Route("/overzicht",  name="vacatureoverzicht")
     * @Template()
     */
    public function vacatureoverzicht()
    {
        $vacatures = $this->vs->getAllVacaturesByDate();
        return ['data' => $vacatures];
    }


    /**
     * @Route("/{id}", name="vacature_detail")
     * @Template()
     */
    public function vacatureDetail($id)
    {
        $vacature = $this->vs->findVacature($id);
        return ['data' => $vacature];
    }
}
