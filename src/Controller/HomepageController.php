<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Service\VacatureService;

/**
 * @Route("/")
 */
class HomepageController extends BaseController
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function index(VacatureService $vs)
    {
        $vacatures = $vs->getAllVacaturesByDate();
        return ['data' => $vacatures];
    }

    /**
     * @Route("/vacatures",  name="vacatureoverzicht")
     * @Template()
     */
    public function vacatures(VacatureService $vs)
    {
        $vacatures = $vs->getAllVacaturesByDate();
        return ['data' => $vacatures];
    }
}
