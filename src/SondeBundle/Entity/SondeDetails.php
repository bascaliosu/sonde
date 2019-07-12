<?php

namespace SondeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SondeDetails
 *
 * @ORM\Table(name="sonde_details")
 * @ORM\Entity(repositoryClass="SondeBundle\Repository\SondeDetailsRepository")
 */
class SondeDetails
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
     * @ORM\Column(name="curent_motor", type="integer", length=6)
     */
    private $curentMotor;

    /**
     * @var integer
     *
     * @ORM\Column(name="putere_motor", type="integer", length=6)
     */
    private $putereMotor;

    /**
     * @var integer
     *
     * @ORM\Column(name="tensiune_motor", type="integer", length=6)
     */
    private $tensiuneMotor;

    /**
     * @var integer
     *
     * @ORM\Column(name="raport_reductor", type="integer", length=6)
     */
    private $raportReductor;

    /**
     * @var integer
     *
     * @ORM\Column(name="fulie_motor", type="integer", length=6)
     */
    private $fulieMotor;

    /**
     * @var integer
     *
     * @ORM\Column(name="fulie_reductor", type="integer", length=6)
     */
    private $fulieReductor;

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
     * @return SondeDetails
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
     * @param $curentMotor
     *
     * @return SondeDetails
     */
    public function setCurentMotor($curentMotor)
    {
        $this->curentMotor = $curentMotor;

        return $this;
    }

    /**
     * @return int
     */
    public function getCurentMotor()
    {
        return $this->curentMotor;
    }

    /**
     * @param $putereMotor
     *
     * @return SondeDetails
     */
    public function setPutereMotor($putereMotor)
    {
        $this->putereMotor = $putereMotor;

        return $this;
    }

    /**
     * @return int
     */
    public function getPutereMotor()
    {
        return $this->putereMotor;
    }

    /**
     * @param $tensiuneMotor
     *
     * @return SondeDetails
     */
    public function setTensiuneMotor($tensiuneMotor)
    {
        $this->tensiuneMotor = $tensiuneMotor;

        return $this;
    }

    /**
     * @return int
     */
    public function getTensiuneMotor()
    {
        return $this->tensiuneMotor;
    }

    /**
     * @param $raportReductor
     *
     * @return SondeDetails
     */
    public function setRaportReductor($raportReductor)
    {
        $this->raportReductor = $raportReductor;

        return $this;
    }

    /**
     * @return int
     */
    public function getRaportReductor()
    {
        return $this->raportReductor;
    }

    /**
     * @param $fulieMotor
     *
     * @return SondeDetails
     */
    public function setFulieMotor($fulieMotor)
    {
        $this->fulieMotor = $fulieMotor;

        return $this;
    }

    /**
     * @return int
     */
    public function getFulieMotor()
    {
        return $this->fulieMotor;
    }

    /**
     * @param $fulieReductor
     *
     * @return SondeDetails
     */
    public function setFulieReductor($fulieReductor)
    {
        $this->fulieReductor = $fulieReductor;

        return $this;
    }

    /**
     * @return int
     */
    public function getFulieReductor()
    {
        return $this->fulieReductor;
    }

    /**
     * @param \DateTime $createdAt
     * @return SondeDetails
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
     * @return SondeDetails
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