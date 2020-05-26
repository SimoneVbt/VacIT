<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Entity\Vacature;

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
        $rep = $this->getDoctrine()->getRepository(Vacature::class);
        $vacatures = $rep->findAll();

        return [
            'vacatures' => $vacatures,
        ];
    }
}
