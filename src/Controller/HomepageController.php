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
    private $vs;

    public function __construct(VacatureService $vs)
    {
        $this->vs = $vs;
    }

    
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function index()
    {
        $vacatures = $this->vs->getAllVacaturesByDate();
        return ['data' => $vacatures];
    }



}
