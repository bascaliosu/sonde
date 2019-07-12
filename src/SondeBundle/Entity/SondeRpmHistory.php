<?php

namespace SondeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sonde
 *
 * @ORM\Table(name="sonde_rpm_history")
 * @ORM\Entity(repositoryClass="SondeBundle\Repository\SondeRpmHistoryRepository")
 */
class SondeRpmHistory
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_sonda", type="integer", length=6)
     */
    private $idSonda;

    /**
     * @var integer
     *
     * @ORM\Column(name="rpm", type="integer", length=5)
     */
    private $rpm;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified_at", type="datetime", nullable=false)
     */
    private $modifiedAt;

    /**
     * Get Id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idSonda
     *
     * @param integer $idSonda
     *
     * @return SondeRpmHistory
     */
    public function setIdSonda($idSonda)
    {
        $this->idSonda = $idSonda;

        return $this;
    }

    /**
     * Get idSonda
     *
     * @return integer
     */
    public function getIdSonda()
    {
        return $this->idSonda;
    }

    /**
     * @param $rpm
     *
     * @return SondeRpmHistory
     */
    public function setRpm($rpm)
    {
        $this->rpm = $rpm;

        return $this;
    }

    /**
     * @return int
     */
    public function getRpm()
    {
        return $this->rpm;
    }

    /**
     * @param \DateTime $createdAt
     * @return SondeRpmHistory
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $modifiedAt
     * @return SondeRpmHistory
     */
    public function setModifiedAt(\DateTime $modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }
}