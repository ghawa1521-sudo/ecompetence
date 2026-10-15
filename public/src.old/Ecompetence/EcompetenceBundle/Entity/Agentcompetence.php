<?php

namespace Ecompetence\EcompetenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agentcompetence
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ecompetence\EcompetenceBundle\Repository\AgentcompetenceRepository")
 */
class Agentcompetence
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
     * @ORM\ManyToOne(targetEntity="Domaine")
     * @ORM\JoinColumn(name="competence_id", referencedColumnName="id", nullable=true)
     */
    private $competence;
    



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
     * @return Agentcompetence
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
     * Set competence
     *
     * @param \Ecompetence\EcompetenceBundle\Entity\Domaine $competence
     *
     * @return Agentcompetence
     */
    public function setCompetence(\Ecompetence\EcompetenceBundle\Entity\Domaine $competence = null)
    {
        $this->competence = $competence;

        return $this;
    }

    /**
     * Get competence
     *
     * @return \Ecompetence\EcompetenceBundle\Entity\Domaine
     */
    public function getCompetence()
    {
        return $this->competence;
    }
}
