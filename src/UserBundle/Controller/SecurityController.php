<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecurityController extends Controller
{
    public function addAction()
    {
        return $this->render('@User/Security/user_home.html.twig', array(
            // ...
        ));
    }

    public function redirectAction()
    {
        $authChecker=$this->container->get('security.authorization_checker');
        if($authChecker->isGranted('ROLE_ADMIN')){
            return $this->render('@User/Security/admin_home.html.twig', array(
                // ...
            ));
        }else if ($authChecker->isGranted('ROLE_USER')) {
            return $this->render('@User/Security/user_home.html.twig', array(// ...
            ));
        }
        else {
            return $this->render('@FOSUser/Security/login.html.twig', array(// ...
            ));
        }
    }

}
