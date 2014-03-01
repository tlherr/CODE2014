<?php

namespace Renegade\Bundle\CarImpactBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Renegade\Bundle\CarImpactBundle\Helpers\StringHelpers;

class ModelRepository extends EntityRepository {
    public function getModelQuery(Make $make, $filter = '')
    {
        $qb = $this->createQueryBuilder('m')
            ->where('m.make = :make')
            ->setParameter('make', $make);

        if (!empty($filter)) {
            $filter = StringHelpers::getCanonical($filter);
            $qb->andWhere('m.canonicalLabel LIKE :filter')
                ->setParameter('filter', sprintf('%%%s%%', $filter))
            ;
        }

        return $qb->getQuery();
    }
} 