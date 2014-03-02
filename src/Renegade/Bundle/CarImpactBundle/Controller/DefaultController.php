<?php

namespace Renegade\Bundle\CarImpactBundle\Controller;

use Renegade\Bundle\CarImpactBundle\Entity\Vehicle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('RenegadeCarImpactBundle:Default:index.html.twig', array());
    }


    public function aboutAction()
    {
        return $this->render('RenegadeCarImpactBundle:Default:about.html.twig', array());
    }


    /**
     * Take a vehicle ID and using some averages and superscrollorama makes a nice scrollable infographic of your vehicle
     */
    public function infographicAction(Vehicle $vehicle) {
        $calc = array(
            'emissions' => ($vehicle->getEmissions()*15200),
            'fuel_used' => (152*((double)$vehicle->getCityLph())),
            'fuel_cost' => (152*((double)$vehicle->getCityLph()))*1.20
        );

        return $this->render('RenegadeCarImpactBundle:Default:infographic.html.twig', array(
                'vehicle' => $vehicle,
                'calc' => $calc
        ));
    }


}
