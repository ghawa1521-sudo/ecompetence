<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sanction
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Repository\SanctionRepository")
 */
class Sanction
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
     * @ORM\Column(name="dateSanct", type="date")
     */
    private $dateSanct;

    /**
     * @var string
     *
     * @ORM\Column(name="motifSanct", type="string", length=255)
     */
    private $motifSanct;


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
     * Set dateSanct
     *
     * @param \DateTime $dateSanct
     *
     * @return Sanction
     */
    public function setDateSanct($dateSanct)
    {
        $this->dateSanct = $dateSanct;

        return $this;
    }

    /**
     * Get dateSanct
     *
     * @return \DateTime
     */
    public function getDateSanct()
    {
        return $this->dateSanct;
    }

    /**
     * Set motifSanct
     *
     * @param string $motifSanct
     *
     * @return Sanction
     */
    public function setMotifSanct($motifSanct)
    {
        $this->motifSanct = $motifSanct;

        return $this;
    }

    /**
     * Get motifSanct
     *
     * @return string
     */
    public function getMotifSanct()
    {
        return $this->motifSanct;
    }

    /**
     * Set agent
     *
     * @param \Agent\AgentBundle\Entity\Agent $agent
     *
     * @return Sanction
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
