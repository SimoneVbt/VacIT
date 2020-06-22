<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

use App\Service\UserService;
use App\Service\VacatureService;
use App\Service\SollicitatieService;

/**
 * @Route("/api")
 */
class ApiController extends BaseController
{
    private $us;
    private $vs;
    private $ss;
    
    public function __construct(UserService $us,
                                VacatureService $vs,
                                SollicitatieService $ss)
    {
        $this->us = $us;
        $this->vs = $vs;
        $this->ss = $ss;
    }


    /**
     * @Route("/download/image/{filename}", name="download_image")
     */
    public function downloadImage($filename)

    {
        $file ='uploads/img/'.$filename;
        return new BinaryFileResponse($file);
    }

    /**
     * @Route("/download/cv/{filename}", name="download_cv")
     */
    public function downloadCv($filename)
    {
        $file = 'uploads/cv/'.$filename;
        return new BinaryFileResponse($file);
    }


    /**
     * @Route("/{user_id}/solliciteer/{vacature_id}", name="ajax_sollicitatie")
     */
    public function nieuweSollicitatie(Request $request, $user_id, $vacature_id)
    {
        $user = $this->us->findUser($user_id);
        if ($this->checkUser($user, $user_id)) {

            $params = $request->request->all();

            if ($this->ss->checkSollicitatie($user_id, $vacature_id)) {
                $this->addFlash('error', 'Je hebt al op deze vacature gesolliciteerd');
                return new Response('Deze gebruiker heeft al op deze vacature gesolliciteerd.');
            }

            $params["user_id"] = $user_id;
            $params["vacature_id"] = $vacature_id;

            $result = $this->ss->saveSollicitatie($params);
            $this->addFlash('success', 'Je sollicitatie is succesvol verstuurd!');
            return new Response("De sollicitatie is verstuurd.");
        }
    }



    /**
     * @Route("/{user_id}/bewerk_vacature/{vacature_id}", name="ajax_bewerk_vacature")
     */
    public function bewerkVacature(Request $request, $user_id, $vacature_id)
    {
        $user = $this->us->findUser($user_id);
        if ($this->checkUser($user, $user_id)) {

            $params = $request->request->all();
            $params["user_id"] = $user_id;
            $params["id"] = $vacature_id;

            $result = $this->vs->saveVacature($params);
            $this->addFlash('success', 'De vacature is succesvol bijgewerkt.');
            return new Response("De vacature is bijgewerkt.");
        }    
    }


    /**
     * @Route("/{user_id}/verwijder_vacature/{vacature_id}", name="ajax_verwijder_vacature")
     */
    public function verwijderVacature(Request $request, $user_id, $vacature_id)
    {
        $user = $this->us->findUser($user_id);
        if ($this->checkUser($user, $user_id)) {

            $result = $this->vs->removeVacature($vacature_id);
            $this->addFlash('success', 'De vacature is succesvol verwijderd.');
            return new Response("De vacature is verwijderd.");
        }
    }


    /**
     * @Route("/{user_id}/nieuwe_vacature", name="ajax_vacature")
     */
    public function nieuweVacature(Request $request, $user_id)
    {
        $user = $this->us->findUser($user_id);
        if ($this->checkUser($user, $user_id)) {
            
            $params = $request->request->all();
            $params["user_id"] = $user_id;

            $result = $this->vs->saveVacature($params);
            $this->addFlash('success', 'De vacature is succesvol geplaatst!');
            return new Response("De vacature is geplaatst!");
        }
    }
    


    /**
     * @Route("/{user_id}/{vacature_id}/verstuur_uitnodiging", name="ajax_uitnodiging")
     */
    public function uitnodiging(Request $request, $user_id, $vacature_id)
    {
        $user = $this->us->findUser($user_id);
        if ($this->checkUser($user, $user_id)) {

            $params = $request->request->all();
            $params["vacature_id"] = $vacature_id;

            $result = $this->ss->saveSollicitatie($params);
            $this->addFlash('success', "De uitnodigingsstatus is succesvol bijgewerkt!");
            return new Response("De uitnodigingsstatus is bijgewerkt.");
        }
    }

    
    /**
     * @Route("/{user_id}/bewerk_profiel", name="ajax_profiel")
     */
    public function bewerkProfiel(Request $request, $user_id)
    {
        $user = $this->us->findUser($user_id);
        if ($this->checkUser($user, $user_id)) {

            $params = $request->request->all();

            if (!empty($_FILES["cv_upload"]["name"])) {
                $upload = $this->uploadCv($user_id);
                $params["cv"] = $upload ? $upload: null;
                
            }
            if (!empty($_FILES["afbeelding_upload"]["name"])) {
                $upload = $this->uploadImage($user_id);
                $params["afbeelding"] = $upload ? $upload : null;
            }

            $result = $this->us->saveUser($params);
            $this->addFlash('success', 'Dit profiel is succesvol bijgewerkt!');

            return new Response("Het profiel is bijgewerkt.");
        }
    }

    /**
     * @Route("/test/{user_id}", name="test")
     */
    public function test($user_id)
    {
        var_dump($_FILES);
        return new Response ('done');
    }


    private function uploadCv($user_id)
    {
        $target_dir = "uploads/cv/";
        $target_file = $target_dir . basename($_FILES["cv_upload"]["name"]); 
        $extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($extension != "pdf" && $extension != "doc" && $extension != "docx") {
            $this->addFlash('error', 'Upload een pdf-, doc- of docx-bestand.');
            return false;
        }
        if ($_FILES["cv_upload"]["size"] > 1000000) {
            $this->addFlash('error', 'Dit bestand is groter dan 1MB.');
            return false;
        }
        
        $new_filename = $target_dir."cv".$user_id.".".$extension;
        
        if (move_uploaded_file($_FILES["cv_upload"]["tmp_name"], $new_filename)) {
            $this->addFlash('success', "Upload cv geslaagd!");
            return ("cv".$user_id.".".$extension);
        };

        $this->addFlash('error', 'Er is iets mis gegaan. Neem contact op met de beheerder van deze website.');
        return false;
        
    }


    private function uploadImage($user_id)
    {
        $target_dir = "uploads/img/";
        $target_file = $target_dir . basename($_FILES["afbeelding_upload"]["name"]); 
        $extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($extension != "png" && $extension != "jpg" && $extension != "jpeg") {
            $this->addFlash('error', 'Upload een jpg-, jpeg- of png-bestand.');
            return false;
        }
        if ($_FILES["afbeelding_upload"]["size"] > 1000000) {
            $this->addFlash('error', 'Dit bestand is groter dan 1MB.');
            return false;
        }

        $new_filename = $target_dir."img".$user_id.".".$extension;

        if (move_uploaded_file($_FILES["afbeelding_upload"]["tmp_name"], $new_filename)) {
            $this->addFlash('success', "Upload afbeelding geslaagd!");
            return ("img".$user_id.".".$extension);
        };

        $this->addFlash('error', 'Er is iets mis gegaan. Neem contact op met de beheerder van deze website.');
        return false;
    }
}
