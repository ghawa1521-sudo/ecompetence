<?php

namespace Ecompetence\EcompetenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AgentEmploi
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ecompetence\EcompetenceBundle\Repository\AgentEmploiRepository")
 */
class AgentEmploi
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
     * @ORM\JoinColumn(name="agent_id", referencedColumnName="matricule", nullable=true)
     */
    private $agent;
    
      /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Emploi")
     * @ORM\JoinColumn(name="emploi_id", referencedColumnName="id", nullable=true)
     */
    private $emploi;
    

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateEmploi", type="date")
     */
    private $dateEmploi;



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
     * Set dateEmploi
     *
     * @param \DateTime $dateEmploi
     *
     * @return AgentEmploi
     */
    public function setDateEmploi($dateEmploi)
    {
        $this->dateEmploi = $dateEmploi;

        return $this;
    }

    /**
     * Get dateEmploi
     *
     * @return \DateTime
     */
    public function getDateEmploi()
    {
        return $this->dateEmploi;
    }

    /**
     * Set agent
     *
     * @param \Agent\AgentBundle\Entity\Agent $agent
     *
     * @return AgentEmploi
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
     * Set emploi
     *
     * @param \Agent\AgentBundle\Entity\Emploi $emploi
     *
     * @return AgentEmploi
     */
    public function setEmploi(\Agent\AgentBundle\Entity\Emploi $emploi = null)
    {
        $this->emploi = $emploi;

        return $this;
    }

    /**
     * Get emploi
     *
     * @return \Agent\AgentBundle\Entity\Emploi
     */
    public function getEmploi()
    {
        return $this->emploi;
    }
}
