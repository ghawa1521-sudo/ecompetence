<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


abstract class Modificationfactory
{
    /**
     * @var integer
     *
     * @ORM\Column(name="etatModif", type="integer",nullable=true)
     */
    protected $etatModif=0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateModif", type="datetime",nullable=true)
     */
    protected $dateModif;

   /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent",  cascade={"persist"})
     * @ORM\JoinColumn(name="matAgentModif", referencedColumnName="id",nullable=true)
     */
    protected $matAgentModif; 

    /**
     * Set etatModif
     *
     * @param integer $etatModif
     *
     * @return Modificationfactory
     */
    public function setEtatModif($etatModif)
    {
        $this->etatModif = $etatModif;

        return $this;
    }

    /**
     * Get etatModif
     *
     * @return integer
     */
    public function getEtatModif()
    {
        return $this->etatModif;
    }

    /**
     * Set dateModif
     *
     * @param \DateTime $dateModif
     *
     * @return Modificationfactory
     */
    public function setDateModif($dateModif)
    {
        $this->dateModif = $dateModif;

        return $this;
    }

    /**
     * Get dateModif
     *
     * @return \DateTime
     */
    public function getDateModif()
    {
        return $this->dateModif;
    }

    /**
     * Set matAgentModif
     *
     * @param \Agent\AgentBundle\Entity\Agent $matAgentModif
     *
     * @return Modificationfactory
     */
    public function setMatAgentModif(\Agent\AgentBundle\Entity\Agent $matAgentModif = null)
    {
        $this->matAgentModif = $matAgentModif;

        return $this;
    }

    /**
     * Get matAgentModif
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getMatAgentModif()
    {
        return $this->matAgentModif;
    }
}
