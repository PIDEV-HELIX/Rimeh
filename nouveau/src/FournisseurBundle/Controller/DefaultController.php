<?php

namespace FournisseurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FournisseurBundle:Default:index.html.twig');
    }
}
