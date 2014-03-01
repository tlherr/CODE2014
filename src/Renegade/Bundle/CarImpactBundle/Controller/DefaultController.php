<?php

namespace Renegade\Bundle\CarImpactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('RenegadeCarImpactBundle:Default:index.html.twig', array());
    }
}
