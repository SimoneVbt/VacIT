<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use App\Entity\Vacature;
use App\Entity\User;

class VacatureController extends BaseController

/**
 * @Route("/vacature/{id}")
 */
{
    /**
     * @Route("/", name="vacature_detail")
     * @Template()
     */
    public function index($id)
    {
        $vacatureRepository = $this->getDoctrine()->getRepository(Vacature::class);
        $vacature = $vacatureRepository->find($id);

        return ['data' => $vacature];
    }
}
