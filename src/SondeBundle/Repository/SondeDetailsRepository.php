<?php

namespace SondeBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SondeDetailsRepository extends EntityRepository
{
    /**
     * @param $sondaId
     * @return array
     */
    public function getDetailsBySondaId($sondaId)
    {
        $qb = $this->createQueryBuilder('sd')
            ->where('sd.idSonda = :sondaId')
            ->orderBy("sd.createdAt", "DESC")
            ->setMaxResults(1)
            ->setParameters(["sondaId" => $sondaId]);

        $details = $qb->getQuery()->getResult();

        return $details;
    }
}