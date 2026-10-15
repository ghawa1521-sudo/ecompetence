<?php

namespace Ecompetence\EcompetenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agent_atout
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Agent_atout
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
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent")
     * @ORM\JoinColumn(name="agent_id", referencedColumnName="id", nullable=true)
     */
    private $agent; 
   
     /**
     * @ORM\ManyToOne(targetEntity="Atout")
     * @ORM\JoinColumn(name="atout_id", referencedColumnName="id", nullable=true)
    
     */
    private $langue; 


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
     * @return Agent_atout
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
     * Set langue
     *
     * @param \Ecompetence\EcompetenceBundle\Entity\Atout $langue
     *
     * @return Agent_atout
     */
    public function setLangue(\Ecompetence\EcompetenceBundle\Entity\Atout $langue = null)
    {
        $this->langue = $langue;

        return $this;
    }

    /**
     * Get langue
     *
     * @return \Ecompetence\EcompetenceBundle\Entity\Atout
     */
    public function getLangue()
    {
        return $this->langue;
    }
}
