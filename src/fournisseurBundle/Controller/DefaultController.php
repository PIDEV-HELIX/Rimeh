<?php

namespace fournisseurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('fournisseurBundle:Default:index.html.twig');
    }
}
