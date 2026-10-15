<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DecisionAgent
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Entity\DecisionAgentRepository")
 */
class DecisionAgent
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
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent",  cascade={"persist"})
     * @ORM\JoinColumn(name="agent", referencedColumnName="id")
     */
    private $agent;
    
     /**
     * @ORM\ManyToOne(targetEntity="Decision",  cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $decision;

     /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAutoAjoutEnreg", type="datetime", nullable=true)
     */
    private $dateAutoAjoutDec;

    /**
     * @ORM\ManyToOne(targetEntity="Agent")
     * @ORM\JoinColumn(name="matAjoutEnreg", referencedColumnName="id", nullable=true)
     */
    private $matAjoutDec;

    public function __construct() {
        
        $this->dateAutoAjoutDec = new \DateTime('now');
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
     * Set agent
     *
     * @param \Agent\AgentBundle\Entity\Agent $agent
     *
     * @return DecisionAgent
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
     * Set decision
     *
     * @param \Agent\AgentBundle\Entity\Decision $decision
     *
     * @return DecisionAgent
     */
    public function setDecision(\Agent\AgentBundle\Entity\Decision $decision = null)
    {
        $this->decision = $decision;

        return $this;
    }

    /**
     * Get decision
     *
     * @return \Agent\AgentBundle\Entity\Decision
     */
    public function getDecision()
    {
        return $this->decision;
    }

    /**
     * Set dateAutoAjoutDec
     *
     * @param \DateTime $dateAutoAjoutDec
     *
     * @return DecisionAgent
     */
    public function setDateAutoAjoutDec($dateAutoAjoutDec)
    {
        $this->dateAutoAjoutDec = $dateAutoAjoutDec;

        return $this;
    }

    /**
     * Get dateAutoAjoutDec
     *
     * @return \DateTime
     */
    public function getDateAutoAjoutDec()
    {
        return $this->dateAutoAjoutDec;
    }

    /**
     * Set matAjoutDec
     *
     * @param \Agent\AgentBundle\Entity\Agent $matAjoutDec
     *
     * @return DecisionAgent
     */
    public function setMatAjoutDec(\Agent\AgentBundle\Entity\Agent $matAjoutDec = null)
    {
        $this->matAjoutDec = $matAjoutDec;

        return $this;
    }

    /**
     * Get matAjoutDec
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getMatAjoutDec()
    {
        return $this->matAjoutDec;
    }
}
