<?php

namespace SondeBundle\Repository;

use Doctrine\ORM\EntityRepository;
use SondeBundle\Entity\Sonde;

class SondeRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function getSonde()
    {
        $sonde = [];
        $qb = $this->createQueryBuilder('s')
            ->orderBy('s.sector', 'ASC');

        $sondeResult = $qb->getQuery()->getResult();

        /** @var Sonde $sonda */
        foreach ($sondeResult as $sonda) {
            $sonde[$sonda->getSector()][] = [
                'id' => $sonda->getId(),
                'name' => $sonda->getName(),
                'ip' => $sonda->getIp()
            ];
        }

        return $sonde;
    }

    /**
     * @param $sector
     *
     * @return array
     */
    public function getSondeBySector($sector)
    {
        $sonde = [];
        $qb = $this->createQueryBuilder('s')
            ->where('s.sector = :sector')
            ->setParameters(["sector" => $sector]);

        $sondeResult = $qb->getQuery()->getResult();

        /** @var Sonde $sonda */
        foreach ($sondeResult as $sonda) {
            $sonde[] = [
                'id' => $sonda->getId(),
                'name' => $sonda->getName(),
                'ip' => $sonda->getIp()
            ];
        }

        return $sonde;
    }
}