<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Provenance
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Repository\ProvenanceRepository")
 */
class Provenance
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="ministere", type="string", length=255)
     */
    private $ministere;

    /**
     * @var string
     *
     * @ORM\Column(name="direction", type="string", length=255)
     */
    private $direction;

    /**
     * @var string
     *
     * @ORM\Column(name="service", type="string", length=255)
     */
    private $service;

    /**
     * @var string
     *
     * @ORM\Column(name="posteOcu", type="string", length=255)
     */
    private $posteOcu;



    public function  __toString()
    {
        return $this->getMinistere();
    }
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ministere
     *
     * @param string $ministere
     *
     * @return Provenance
     */
    public function setMinistere($ministere)
    {
        $this->ministere = $ministere;

        return $this;
    }

    /**
     * Get ministere
     *
     * @return string
     */
    public function getMinistere()
    {
        return $this->ministere;
    }

    /**
     * Set direction
     *
     * @param string $direction
     *
     * @return Provenance
     */
    public function setDirection($direction)
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * Get direction
     *
     * @return string
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * Set service
     *
     * @param string $service
     *
     * @return Provenance
     */
    public function setService($service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Set posteOcu
     *
     * @param string $posteOcu
     *
     * @return Provenance
     */
    public function setPosteOcu($posteOcu)
    {
        $this->posteOcu = $posteOcu;

        return $this;
    }

    /**
     * Get posteOcu
     *
     * @return string
     */
    public function getPosteOcu()
    {
        return $this->posteOcu;
    }
}
