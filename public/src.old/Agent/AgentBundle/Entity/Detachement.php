<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM; 

/**
 * Detachement
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Repository\DetachementRepository")
 */
class Detachement extends Modificationfactory
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
     * @ORM\Column(name="datecreation", type="datetime", columnDefinition="timestamp default current_timestamp on update current_timestamp")
     */
    private $datecreation;

    /**
     * @ORM\ManyToOne(targetEntity="NatureDetachement")
     * @ORM\JoinColumn(name="naturedetachement", referencedColumnName="id", nullable=true)
     */
    private $naturedetachement;


    /**
     * @ORM\ManyToOne(targetEntity="Agent")
     * @ORM\JoinColumn(name="nameactor", referencedColumnName="id", nullable=true)
     */
    private $nameactor;

    /**
     * @var string
     *
     * @ORM\Column(name="numNote", type="string", length=150)
     */
    private $numNote;

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Document", cascade={"persist"})
     * @ORM\JoinColumn(name="pj", referencedColumnName="id")
     */
    private $pj;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNumNote", type="datetime")
     */
    private $dateNumNote;


    /**
     * @ORM\ManyToOne(targetEntity="Provenance")
     * @ORM\JoinColumn(name="id_provenance", referencedColumnName="id", nullable=true)
     */
    protected $Provenance;

    /**
     * @var string
     *
     * @ORM\Column(name="objetnote", type="text", length=1000)
     */
    private $objetnote;

   /**
     * One Detachement has One Agent.
     * @ORM\OneToOne(targetEntity="Agent", inversedBy="detachement")
     * @ORM\JoinColumn(name="agent", referencedColumnName="id")
     */
    private $agent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDetachement", type="datetime", nullable=true)
     */
    private $dateDetachement;

    public function __construct() {
        $this->datecreation = new \DateTime('now');
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
     * Set datecreation
     *
     * @param \DateTime $datecreation
     *
     * @return Detachement
     */
    public function setDatecreation($datecreation)
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    /**
     * Get datecreation
     *
     * @return \DateTime
     */
    public function getDatecreation()
    {
        return $this->datecreation;
    }

    /**
     * Set numNote
     *
     * @param string $numNote
     *
     * @return Detachement
     */
    public function setNumNote($numNote)
    {
        $this->numNote = $numNote;

        return $this;
    }

    /**
     * Get numNote
     *
     * @return string
     */
    public function getNumNote()
    {
        return $this->numNote;
    }

    /**
     * Set dateNumNote
     *
     * @param \DateTime $dateNumNote
     *
     * @return Detachement
     */
    public function setDateNumNote($dateNumNote)
    {
        $this->dateNumNote = $dateNumNote;

        return $this;
    }

    /**
     * Get dateNumNote
     *
     * @return \DateTime
     */
    public function getDateNumNote()
    {
        return $this->dateNumNote;
    }

    /**
     * Set objetnote
     *
     * @param string $objetnote
     *
     * @return Detachement
     */
    public function setObjetnote($objetnote)
    {
        $this->objetnote = $objetnote;

        return $this;
    }

    /**
     * Get objetnote
     *
     * @return string
     */
    public function getObjetnote()
    {
        return $this->objetnote;
    }

    /**
     * Set naturedetachement
     *
     * @param \Agent\AgentBundle\Entity\NatureDetachement $naturedetachement
     *
     * @return Detachement
     */
    public function setNaturedetachement(\Agent\AgentBundle\Entity\NatureDetachement $naturedetachement = null)
    {
        $this->naturedetachement = $naturedetachement;

        return $this;
    }

    /**
     * Get naturedetachement
     *
     * @return \Agent\AgentBundle\Entity\NatureDetachement
     */
    public function getNaturedetachement()
    {
        return $this->naturedetachement;
    }

    /**
     * Set nameactor
     *
     * @param \Agent\AgentBundle\Entity\Agent $nameactor
     *
     * @return Detachement
     */
    public function setNameactor(\Agent\AgentBundle\Entity\Agent $nameactor = null)
    {
        $this->nameactor = $nameactor;

        return $this;
    }

    /**
     * Get nameactor
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getNameactor()
    {
        return $this->nameactor;
    }

    /**
     * Set pj
     *
     * @param \Agent\AgentBundle\Entity\Document $pj
     *
     * @return Detachement
     */
    public function setPj(\Agent\AgentBundle\Entity\Document $pj = null)
    {
        $this->pj = $pj;

        return $this;
    }

    /**
     * Get pj
     *
     * @return \Agent\AgentBundle\Entity\Document
     */
    public function getPj()
    {
        return $this->pj;
    }

    /**
     * Set provenance
     *
     * @param \Agent\AgentBundle\Entity\Provenance $provenance
     *
     * @return Detachement
     */
    public function setProvenance(\Agent\AgentBundle\Entity\Provenance $provenance = null)
    {
        $this->Provenance = $provenance;

        return $this;
    }

    /**
     * Get provenance
     *
     * @return \Agent\AgentBundle\Entity\Provenance
     */
    public function getProvenance()
    {
        return $this->Provenance;
    }

    /**
     * Set agent
     *
     * @param \Agent\AgentBundle\Entity\Agent $agent
     *
     * @return Detachement
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
     * Set dateDetachement
     *
     * @param \DateTime $dateDetachement
     *
     * @return Detachement
     */
    public function setDateDetachement($dateDetachement)
    {
        $this->dateDetachement = $dateDetachement;

        return $this;
    }

    /**
     * Get dateDetachement
     *
     * @return \DateTime
     */
    public function getDateDetachement()
    {
        return $this->dateDetachement;
    }
}
