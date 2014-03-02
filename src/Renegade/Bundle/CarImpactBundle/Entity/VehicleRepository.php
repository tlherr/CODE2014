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
            'modifiers' => $vehicle->getModifiers()
        ));
    }
    public function getVehiclesQuery(Model $model, $filter = '')
    {
        $qb = $this->createQueryBuilder('v')
            ->where('v.model = :model')
            ->setParameter('model', $model);

        if (!empty($filter)) {
            $filter = StringHelpers::getCanonical($filter);
            $qb->andWhere('v.canonicalLabel LIKE :filter')
                ->setParameter('filter', sprintf('%%%s%%', $filter))
            ;
        }

        return $qb->getQuery();
    }
} 