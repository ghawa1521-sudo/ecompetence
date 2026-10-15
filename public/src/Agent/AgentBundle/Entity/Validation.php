<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Validation
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Repository\ValidationRepository")
 */
class Validation
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
     * @ORM\Column(name="date", type="datetimetz")
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="niveau", type="integer")
     */
    private $niveau;

     /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent",  cascade={"persist"})
     * @ORM\JoinColumn(name="agent", referencedColumnName="id")
     */
    private $agent;  ///////Agent Validateur

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Conges", inversedBy="validation", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)    
     * 
     */

    private $conges;

    public function __construct() {
        $this->date = new \DateTime();
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Validation
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set niveau
     *
     * @param integer $niveau
     *
     * @return Validation
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * Get niveau
     *
     * @return integer
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * Set agent
     *
     * @param \Agent\AgentBundle\Entity\Agent $agent
     *
     * @return Validation
     */
    public function setAgent(\Agent\AgentBundle\Entity\Agent $agent = null)
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * Get agent
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * Set conges
     *
     * @param \Agent\AgentBundle\Entity\Conges $conges
     *
     * @return Validation
     */
    public function setConges(\Agent\AgentBundle\Entity\Conges $conges)
    {
        $this->conges = $conges;

        return $this;
    }

    /**
     * Get conges
     *
     * @return \Agent\AgentBundle\Entity\Conges
     */
    public function getConges()
    {
        return $this->conges;
    }
}
