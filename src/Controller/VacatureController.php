<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Service\VacatureService;

/**
 * @Route("/vacature/{id}")
 */
class VacatureController extends BaseController
{
    /**
     * @Route("/", name="vacature_detail")
     * @Template()
     */
    public function index(VacatureService $vs, $id)
    {
        $vacature = $vs->findVacature($id);
        return ['data' => $vacature];
    }
}
