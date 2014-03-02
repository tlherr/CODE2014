<?php

namespace Renegade\Bundle\CarImpactBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Renegade\Bundle\CarImpactBundle\Entity\Make;
use Renegade\Bundle\CarImpactBundle\Entity\MakeRepository;
use Renegade\Bundle\CarImpactBundle\Entity\Model;
use Renegade\Bundle\CarImpactBundle\Entity\ModelRepository;
use Renegade\Bundle\CarImpactBundle\Entity\Vehicle;
use Renegade\Bundle\CarImpactBundle\Entity\VehicleRepository;
use Symfony\Component\HttpFoundation\Request;

class ApiV1Controller extends FOSRestController {
    /**
     * @var ModelRepository
     */
    protected $modelRepository;

    /**
     * @var MakeRepository
     */
    protected $makeRepository;

    /**
     * @var VehicleRepository
     */
    protected $vehicleRepository;

    /**
     * Get all makes
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getMakesAction(Request $request)
    {
        $filter = $request->query->get('q', '');
        $makes = $this->getMakeRepository()->getMakeQuery($filter)->execute();
        $data = array();

        /**
         * @var Make $make
         */
        foreach ($makes as $make) {
            $data[] = $make->serialize();
        }

        $view = $this->view($data, 200);
        return $this->handleView($view);
    }

    /**
     * Get make by ID
     *
     * @param Make $make
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getMakeAction(Make $make)
    {
        $view = $this->view($make->serialize(), 200);
        return $this->handleView($view);
    }

    /**
     * Get models by make
     *
     * @param Request $request
     * @param Make $make
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getMakeModelsAction(Request $request, Make $make)
    {
        $filter = $request->query->get('q', '');
        $models = $this->getModelRepository()->getModelQuery($make, $filter)->execute();
        $data = array();

        /**
         * @var Model $model
         */
        foreach ($models as $model) {
            $data[] = array(
                'id' => $model->getId(),
                'make_id' => $model->getMake()->getId(),
                'label' => $model->getLabel(),
                'canonical_label' => $model->getCanonicalLabel(),
            );
        }

        $view = $this->view($data, 200);
        return $this->handleView($view);
    }

    /**
     * @param Model $model
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getModelVehiclesAction(Model $model)
    {
        $vehicles = $this->getVehicleRepository()->findBy(array('model' => $model));
        $data = array();
        foreach ($vehicles as $vehicle) {
            $data[] = $vehicle->serialize();
        }

        $view = $this->view($data, 200);
        return $this->handleView($view);
    }


    /**
     * Get all models
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getModelsAction()
    {
        $models = $this->getModelRepository()->findAll();
        $data = array();
        foreach ($models as $model) {
            $data[] = $model->serialize();
        }

        $view = $this->view($data, 200);
        return $this->handleView($view);
    }

    /**
     * Get model by id
     *
     * @param Model $model
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getModelAction(Model $model)
    {
        $view = $this->view($model->serialize(), 200);
        return $this->handleView($view);
    }

    /**
     * Get
     * @param Model $model
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getModelYearsAction(Model $model)
    {
        $vehicles = $this->getVehicleRepository()->findBy(array('model' => $model));
        $data = array();
        $yearsSeen = array();
        /**
         * @var Vehicle $vehicle
         */
        foreach ($vehicles as $vehicle) {
            if (!array_key_exists($vehicle->getYear(), $yearsSeen)) {
                $yearsSeen[$vehicle->getYear()] = true;
                $data[] = array(
                    'year' => $vehicle->getYear(),
                );
                // Detach vehicle to save some memory
                $this->getDoctrine()->getManager()->detach($vehicle);
            }
        }

        $view = $this->view($data, 200);
        return $this->handleView($view);
    }

    /**
     * Get years that model was available
     *
     * @param Model $model
     * @param $year
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getModelYearAction(Model $model, $year)
    {
        $vehicles = $this->getVehicleRepository()->findBy(array('model' => $model, 'year' => $year));
        $data = array();

        /**
         * @var Vehicle $vehicle
         */
        foreach ($vehicles as $vehicle) {
            $data[] = $vehicle->serialize();
        }

        $view = $this->view($data, 200);
        return $this->handleView($view);
    }

    /**
     * Get a vehicle by id
     *
     * @param Vehicle $vehicle
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getVehicleAction(Vehicle $vehicle)
    {
        $view = $this->view($vehicle->serialize(), 200);
        return $this->handleView($view);
    }

    /**
     * @return ModelRepository
     */
    private function getModelRepository()
    {
        if (null === $this->modelRepository) {
            $this->modelRepository = $this->getDoctrine()->getManager()->getRepository('RenegadeCarImpactBundle:Model');
        }

        return $this->modelRepository;
    }

    /**
     * @return MakeRepository
     */
    private function getMakeRepository()
    {
        if (null === $this->makeRepository) {
            $this->makeRepository = $this->getDoctrine()->getManager()->getRepository('RenegadeCarImpactBundle:Make');
        }

        return $this->makeRepository;
    }

    /**
     * @return VehicleRepository
     */
    private function getVehicleRepository()
    {
        if (null === $this->vehicleRepository) {
            $this->vehicleRepository = $this->getDoctrine()->getManager()->getRepository('RenegadeCarImpactBundle:Vehicle');
        }

        return $this->vehicleRepository;
    }
} 