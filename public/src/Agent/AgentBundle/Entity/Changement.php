<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Changement
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Changement
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
     * @ORM\Column(name="dateCreation", type="datetime")
     */
    private $dateCreation;

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\DirectionGenerale")
     * @ORM\JoinColumn(name="CODE_DG_OLD", referencedColumnName="CODE_DG", nullable=true)
     */
    private $oldCodeDg;

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Direction")
     * @ORM\JoinColumn(name="CODE_DC_OLD", referencedColumnName="id", nullable=true)
     */
    private $oldCodeDc;

     /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\SousDirection")
     * @ORM\JoinColumn(name="CODE_SD_OLD", referencedColumnName="CODE_SD", nullable=true)
     */
    private $oldCodeSd;
    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\ServiceDirection")
     * @ORM\JoinColumn(name="CODE_SC_OLD", referencedColumnName="CODE_SC", nullable=true)
     */
    private $oldCodeSc;

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\DirectionGenerale")
     * @ORM\JoinColumn(name="CODE_DG_NEW", referencedColumnName="CODE_DG", nullable=true)
     */
    private $newCodeDg;

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Direction")
     * @ORM\JoinColumn(name="CODE_DC_NEW", referencedColumnName="id", nullable=true)
     */
    private $newCodeDc;

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\SousDirection")
     * @ORM\JoinColumn(name="CODE_SD_NEW", referencedColumnName="CODE_SD", nullable=true)
     */
    private $newCodeSd;
    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\ServiceDirection")
     * @ORM\JoinColumn(name="CODE_SC_NEW", referencedColumnName="CODE_SC", nullable=true)
     */
    private $newCodeSc;

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent",  cascade={"persist"})
     * @ORM\JoinColumn(name="matEnreg", referencedColumnName="id",nullable=true)
     */
    private $matEnreg;

     /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent",  cascade={"persist"})
     * @ORM\JoinColumn(name="matAgent", referencedColumnName="id",nullable=true)
     */
    private $matAgent;
    public function __construct() {
        $this->dateCreation = new \DateTime();
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
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Changement
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set oldCodeDg
     *
     * @param \Agent\AgentBundle\Entity\DirectionGenerale $oldCodeDg
     *
     * @return Changement
     */
    public function setOldCodeDg(\Agent\AgentBundle\Entity\DirectionGenerale $oldCodeDg = null)
    {
        $this->oldCodeDg = $oldCodeDg;

        return $this;
    }

    /**
     * Get oldCodeDg
     *
     * @return \Agent\AgentBundle\Entity\DirectionGenerale
     */
    public function getOldCodeDg()
    {
        return $this->oldCodeDg;
    }

    /**
     * Set oldCodeDc
     *
     * @param \Agent\AgentBundle\Entity\Direction $oldCodeDc
     *
     * @return Changement
     */
    public function setOldCodeDc(\Agent\AgentBundle\Entity\Direction $oldCodeDc = null)
    {
        $this->oldCodeDc = $oldCodeDc;

        return $this;
    }

    /**
     * Get oldCodeDc
     *
     * @return \Agent\AgentBundle\Entity\Direction
     */
    public function getOldCodeDc()
    {
        return $this->oldCodeDc;
    }

    /**
     * Set oldCodeSd
     *
     * @param \Agent\AgentBundle\Entity\SousDirection $oldCodeSd
     *
     * @return Changement
     */
    public function setOldCodeSd(\Agent\AgentBundle\Entity\SousDirection $oldCodeSd = null)
    {
        $this->oldCodeSd = $oldCodeSd;

        return $this;
    }

    /**
     * Get oldCodeSd
     *
     * @return \Agent\AgentBundle\Entity\SousDirection
     */
    public function getOldCodeSd()
    {
        return $this->oldCodeSd;
    }

    /**
     * Set oldCodeSc
     *
     * @param \Agent\AgentBundle\Entity\ServiceDirection $oldCodeSc
     *
     * @return Changement
     */
    public function setOldCodeSc(\Agent\AgentBundle\Entity\ServiceDirection $oldCodeSc = null)
    {
        $this->oldCodeSc = $oldCodeSc;

        return $this;
    }

    /**
     * Get oldCodeSc
     *
     * @return \Agent\AgentBundle\Entity\ServiceDirection
     */
    public function getOldCodeSc()
    {
        return $this->oldCodeSc;
    }

    /**
     * Set newCodeDg
     *
     * @param \Agent\AgentBundle\Entity\DirectionGenerale $newCodeDg
     *
     * @return Changement
     */
    public function setNewCodeDg(\Agent\AgentBundle\Entity\DirectionGenerale $newCodeDg = null)
    {
        $this->newCodeDg = $newCodeDg;

        return $this;
    }

    /**
     * Get newCodeDg
     *
     * @return \Agent\AgentBundle\Entity\DirectionGenerale
     */
    public function getNewCodeDg()
    {
        return $this->newCodeDg;
    }

    /**
     * Set newCodeDc
     *
     * @param \Agent\AgentBundle\Entity\Direction $newCodeDc
     *
     * @return Changement
     */
    public function setNewCodeDc(\Agent\AgentBundle\Entity\Direction $newCodeDc = null)
    {
        $this->newCodeDc = $newCodeDc;

        return $this;
    }

    /**
     * Get newCodeDc
     *
     * @return \Agent\AgentBundle\Entity\Direction
     */
    public function getNewCodeDc()
    {
        return $this->newCodeDc;
    }

    /**
     * Set newCodeSd
     *
     * @param \Agent\AgentBundle\Entity\SousDirection $newCodeSd
     *
     * @return Changement
     */
    public function setNewCodeSd(\Agent\AgentBundle\Entity\SousDirection $newCodeSd = null)
    {
        $this->newCodeSd = $newCodeSd;

        return $this;
    }

    /**
     * Get newCodeSd
     *
     * @return \Agent\AgentBundle\Entity\SousDirection
     */
    public function getNewCodeSd()
    {
        return $this->newCodeSd;
    }

    /**
     * Set newCodeSc
     *
     * @param \Agent\AgentBundle\Entity\ServiceDirection $newCodeSc
     *
     * @return Changement
     */
    public function setNewCodeSc(\Agent\AgentBundle\Entity\ServiceDirection $newCodeSc = null)
    {
        $this->newCodeSc = $newCodeSc;

        return $this;
    }

    /**
     * Get newCodeSc
     *
     * @return \Agent\AgentBundle\Entity\ServiceDirection
     */
    public function getNewCodeSc()
    {
        return $this->newCodeSc;
    }

    /**
     * Set matEnreg
     *
     * @param \Agent\AgentBundle\Entity\Agent $matEnreg
     *
     * @return Changement
     */
    public function setMatEnreg(\Agent\AgentBundle\Entity\Agent $matEnreg = null)
    {
        $this->matEnreg = $matEnreg;

        return $this;
    }

    /**
     * Get matEnreg
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getMatEnreg()
    {
        return $this->matEnreg;
    }

    /**
     * Set matAgent
     *
     * @param \Agent\AgentBundle\Entity\Agent $matAgent
     *
     * @return Changement
     */
    public function setMatAgent(\Agent\AgentBundle\Entity\Agent $matAgent = null)
    {
        $this->matAgent = $matAgent;

        return $this;
    }

    /**
     * Get matAgent
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getMatAgent()
    {
        return $this->matAgent;
    }
}
