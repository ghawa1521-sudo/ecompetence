<?php

namespace Ecompetence\EcompetenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AgentFonction
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ecompetence\EcompetenceBundle\Repository\AgentFonctionRepository")
 */
class AgentFonction
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
     * @ORM\Column(name="DateFonction", type="date")
     */
    private $dateFonction;


    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent")
     * @ORM\JoinColumn(name="agent_id", referencedColumnName="id", nullable=true)
     */
    private $agent;
    
      /**
     * @ORM\ManyToOne(targetEntity="Fonctioncompetence")
     * @ORM\JoinColumn(name="Fonction_id", referencedColumnName="id", nullable=true)
     */
    private $fonction;

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
     * Set dateFonction
     *
     * @param \DateTime $dateFonction
     *
     * @return AgentFonction
     */
    public function setDateFonction($dateFonction)
    {
        $this->dateFonction = $dateFonction;

        return $this;
    }

    /**
     * Get dateFonction
     *
     * @return \DateTime
     */
    public function getDateFonction()
    {
        return $this->dateFonction;
    }

    /**
     * Set agent
     *
     * @param \Agent\AgentBundle\Entity\Agent $agent
     *
     * @return AgentFonction
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
     * Set fonction
     *
     * @param \Ecompetence\EcompetenceBundle\Entity\Fonctioncompetence $fonction
     *
     * @return AgentFonction
     */
    public function setFonction(\Ecompetence\EcompetenceBundle\Entity\Fonctioncompetence $fonction = null)
    {
        $this->fonction = $fonction;

        return $this;
    }

    /**
     * Get fonction
     *
     * @return \Ecompetence\EcompetenceBundle\Entity\Fonctioncompetence
     */
    public function getFonction()
    {
        return $this->fonction;
    }
}
