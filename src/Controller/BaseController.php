<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
// use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class BaseController extends AbstractController
{
    public function __construct()
    {
        
    }

    public function checkUser($user, $id, $multiple = false) {
        $userObj = $this->getUser();
        if ($userObj->getId() == $id) {
            return true;
        } else {
            if ($multiple) {
                return false;
            } else {
                throw new AccessDeniedException ('U heeft geen toegang tot deze pagina.');
            }
        }
    }
}
