<?php

namespace Renegade\Bundle\CarImpactBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Renegade\Bundle\CarImpactBundle\Helpers\StringHelpers;

class MakeRepository extends EntityRepository {
    /**
     * @param string $filter
     * @return \Doctrine\ORM\Query
     */
    public function getMakeQuery($filter = '')
    {
        $qb = $this->createQueryBuilder('m')
            ->orderBy('m.canonicalLabel');

        if (!empty($filter)) {
            $filter = StringHelpers::getCanonical($filter);
            $qb->where('m.canonicalLabel LIKE :filter')
                ->setParameter('filter', sprintf('%%%s%%', $filter))
            ;
        }

        return $qb->getQuery();
    }
} 