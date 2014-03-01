<?php

namespace Renegade\Bundle\CarImpactBundle\Entity;

use Doctrine\ORM\EntityRepository;

class VehicleRepository extends EntityRepository
{
    public function exists(Vehicle $vehicle)
    {
        return null !== $this->findOneBy(array(
            'model' => $vehicle->getModel(),
            'year' => $vehicle->getYear(),
            'engineSize' => $vehicle->getEngineSize(),
            'highOutputEngine' => $vehicle->getHighOutputEngine(),
            'cylinders' => $vehicle->getCylinders(),
            'transmissionType' => $vehicle->getTransmissionType(),
            'fuelType' => $vehicle->getFuelType(),
        ));
    }
} 