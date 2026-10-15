<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recompense
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Repository\RecompenseRepository")
 */
class Recompense
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
     * @var \DateTime
     *
     * @ORM\Column(name="datePrix", type="date")
     */
    private $datePrix;

    /**
     * @var string
     *
     * @ORM\Column(name="libPrix", type="string", length=255)
     */
    private $libPrix;

    /**
     * @var string
     *
     * @ORM\Column(name="motifPrix", type="string", length=255)
     */
    private $motifPrix;


    /**
     * @ORM\ManyToOne(targetEntity="Agent")
     * @ORM\JoinColumn(name="agent_matricule", referencedColumnName="id")
     */
    protected $Agent;

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
     * Set datePrix
     *
     * @param \DateTime $datePrix
     *
     * @return Recompense
     */
    public function setDatePrix($datePrix)
    {
        $this->datePrix = $datePrix;

        return $this;
    }

    /**
     * Get datePrix
     *
     * @return \DateTime
     */
    public function getDatePrix()
    {
        return $this->datePrix;
    }

    /**
     * Set libPrix
     *
     * @param string $libPrix
     *
     * @return Recompense
     */
    public function setLibPrix($libPrix)
    {
        $this->libPrix = $libPrix;

        return $this;
    }

    /**
     * Get libPrix
     *
     * @return string
     */
    public function getLibPrix()
    {
        return $this->libPrix;
    }

    /**
     * Set motifPrix
     *
     * @param string $motifPrix
     *
     * @return Recompense
     */
    public function setMotifPrix($motifPrix)
    {
        $this->motifPrix = $motifPrix;

        return $this;
    }

    /**
     * Get motifPrix
     *
     * @return string
     */
    public function getMotifPrix()
    {
        return $this->motifPrix;
    }

    /**
     * Set agent
     *
     * @param \Agent\AgentBundle\Entity\Agent $agent
     *
     * @return Recompense
     */
    public function setAgent(\Agent\AgentBundle\Entity\Agent $agent = null)
    {
        $this->Agent = $agent;

        return $this;
    }

    /**
     * Get agent
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getAgent()
    {
        return $this->Agent;
    }
}
