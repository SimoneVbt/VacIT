<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Service\UserService;
use App\Service\VacatureService;
use App\Service\SollicitatieService;

/**
 * @Route("/ajax")
 */

class AjaxController extends BaseController
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
     * @Route("/{user_id}/solliciteer/{vacature_id}", name="ajax_sollicitatie")
     */
    public function nieuweSollicitatie(Request $request, $user_id, $vacature_id)
    {
        $user = $this->us->findUser($user_id);
        if ($this->checkUser($user, $user_id)) {

            $params = $request->request->all();
            $params["user_id"] = $user_id;
            $params["vacature_id"] = $vacature_id;

            $result = $this->ss->saveSollicitatie($params);
            $this->addFlash('Je sollicitatie is succesvol verstuurd!');
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
            $this->addFlash('De vacature is bijgewerkt.');
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
            $this->addFlash('success', 'De vacature is verwijderd.');
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

            if (!empty($_FILES["cv_upload"]) && $_FILES["cv_upload"] != "") {
                $upload = $this->uploadCv($user_id);
                if ($upload != "") {
                    $params["cv"] = $upload;
                }
            }
            if (!empty($_FILES["afbeelding_upload"])) {
                $upload = $this->uploadImage($user_id);
                if ($upload != "") {
                    $params["afbeelding"] = $upload;
                }
            }

            $result = $this->us->saveUser($params);
            $this->addFlash('success', 'Dit profiel is succesvol bijgewerkt!');
            dump($_FILES);
            return new Response("Het profiel is bijgewerkt.");
        }
    }


    private function uploadCv($user_id)
    {
        $target_dir = "uploads/cv/";
        $target_file = $target_dir . basename($_FILES["cv_upload"]["name"]); 
        $extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (file_exists($target_file)) {
            $this->addFlash('error', 'Dit bestand is al geüpload.');
            return false;
        }
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
        };

        return ("cv".$user_id.".".$extension);
    }


    private function uploadImage($user_id)
    {
        $target_dir = "uploads/img/";
        $target_file = $target_dir . basename($_FILES["afbeelding_upload"]["name"]); 
        $extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (file_exists($target_file)) {
            $this->addFlash('error', 'Deze afbeelding is al geüpload.');
            return false;
        }
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
        };

        return ("img".$user_id.".".$extension);
    }
}
