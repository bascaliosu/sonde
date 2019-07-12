<?php

namespace SondeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sonde
 *
 * @ORM\Table(name="sonde")
 * @ORM\Entity(repositoryClass="SondeBundle\Repository\SondeRepository")
 */
class Sonde
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="sector", type="integer", length=6)
     */
    private $sector;

    /**
     * @var integer
     *
     * @ORM\Column(name="ip", type="integer", length=10)
     */
    private $ip;

    /**
     * @var integer
     *
     * @ORM\Column(name="rpm", type="integer", length=5)
     */
    private $rpm;


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
     * Set name
     *
     * @param string $name
     *
     * @return Sonde
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $sector
     *
     * @return Sonde
     */
    public function setSector($sector)
    {
        $this->sector = $sector;

        return $this;
    }

    /**
     * @return int
     */
    public function getSector()
    {
        return $this->sector;
    }

    /**
     * @param $ip
     *
     * @return $this
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * @return int
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param $rpm
     *
     * @return $this
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
}