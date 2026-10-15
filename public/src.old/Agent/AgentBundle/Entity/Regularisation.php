<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Regularisation
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Repository\RegularisationRepository")
 */
class Regularisation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    //1: emploi
    //2: Fonction
    /**
     * @var integer
     *
     * @ORM\Column(name="nature", type="integer")
     */
    private $nature;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime")
     */
    private $dateCreation;

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent",  cascade={"persist"})
     * @ORM\JoinColumn(name="matAgent", referencedColumnName="id",nullable=true)
     */
    private $matAgent;

    /**
     * @var string
     *
     * @ORM\Column(name="old", type="string", length=255)
     */
    private $old;

    /**
     * @var integer
     *
     * @ORM\Column(name="new", type="integer")
     */
    private $new;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateOld", type="datetime", nullable=true)
     */
    private $dateOld;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNew", type="datetime", nullable=true)
     */
    private $dateNew;

   /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent",  cascade={"persist"})
     * @ORM\JoinColumn(name="agent", referencedColumnName="id",nullable=true)
     */
    private $agent;

    /**
     * @var string
     *
     * @ORM\Column(name="numNote", type="string", length=50)
     */
    private $numNote;

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Document", cascade={"persist"})
     * @ORM\JoinColumn(name="id_pj_old", referencedColumnName="id")
     */
    private $pj;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNumNote", type="datetime")
     */
    private $dateNumNote;

    /**
     * @var integer
     *
     * @ORM\Column(name="etatModif", type="integer",nullable=true)
     */
    private $etatModif=0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateModif", type="datetime",nullable=true)
     */
    private $dateModif;

   /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent",  cascade={"persist"})
     * @ORM\JoinColumn(name="matAgentModif", referencedColumnName="id",nullable=true)
     */
    private $matAgentModif;

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Document", cascade={"persist"})
     * @ORM\JoinColumn(name="id_pj_new", referencedColumnName="id")
     */
    private $pjNumerise;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateSigneNew", type="datetime",nullable=true)
     */
    private $dateSigneNew;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNumeriseAutoNew", type="datetime",nullable=true)
     */
    private $dateNumeriseAutoNew;

    /**
     * @var string
     *
     * @ORM\Column(name="matAgentNumerise", type="string", length=20, nullable=true)
     */
    private $matAgentNumerise;

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Document", cascade={"persist"})
     * @ORM\JoinColumn(name="id_pj_Justificatif", referencedColumnName="id")
     */
    private $pjJustificatif;

    /**
     * @var integer
     *
     * @ORM\Column(name="etatImprimer", type="integer",nullable=true)
     */
    private $etatImprimer=0;

     /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\DirectionGenerale")
     * @ORM\JoinColumn(name="CODE_DG", referencedColumnName="CODE_DG", nullable=true)
     */
    protected $code_dg;

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\SousDirection")
     * @ORM\JoinColumn(name="CODE_SD", referencedColumnName="CODE_SD", nullable=true)
     */
    protected $code_sd;

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\ServiceDirection")
     * @ORM\JoinColumn(name="CODE_SC", referencedColumnName="CODE_SC", nullable=true)
     */
    protected $code_sc;

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Direction")
     * @ORM\JoinColumn(name="CODE_DC", referencedColumnName="id", nullable=true)
     */
    private $code_dc;

    /**
     * @var string
     *
     * @ORM\Column(name="justificaton", type="string", length=30,nullable=true)
     */
    private $justificaton;
  public function __construct() {
        $this->dateCreation = new \DateTime();
    }

   public function getServiceActuel() {


        $service = null;
        if ($this->getCodeSc()) {
            $service = $this->getCodeSc();
        } elseif ($this->getCodeSd()) {
            $service = $this->getCodeSd();
        } elseif ($this->getCodeDc()) {
            $service = $this->getCodeDc();
        } elseif ($this->getCodeDg()) {
            $service = $this->getCodeDg();
        }
        return $service;
    }

public function retourNature(){
    if ($this->nature==1){
        $retour = "Régularisation Emploi";
    }else{
        $retour = "Régularisation Fonction";
    }
    return $retour;
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
     * Set nature
     *
     * @param integer $nature
     *
     * @return Regularisation
     */
    public function setNature($nature)
    {
        $this->nature = $nature;

        return $this;
    }

    /**
     * Get nature
     *
     * @return integer
     */
    public function getNature()
    {
        return $this->nature;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Regularisation
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
     * Set old
     *
     * @param string $old
     *
     * @return Regularisation
     */
    public function setOld($old)
    {
        $this->old = $old;

        return $this;
    }

    /**
     * Get old
     *
     * @return string
     */
    public function getOld()
    {
        return $this->old;
    }

    /**
     * Set new
     *
     * @param integer $new
     *
     * @return Regularisation
     */
    public function setNew($new)
    {
        $this->new = $new;

        return $this;
    }

    /**
     * Get new
     *
     * @return integer
     */
    public function getNew()
    {
        return $this->new;
    }

    /**
     * Set dateOld
     *
     * @param \DateTime $dateOld
     *
     * @return Regularisation
     */
    public function setDateOld($dateOld)
    {
        $this->dateOld = $dateOld;

        return $this;
    }

    /**
     * Get dateOld
     *
     * @return \DateTime
     */
    public function getDateOld()
    {
        return $this->dateOld;
    }

    /**
     * Set dateNew
     *
     * @param \DateTime $dateNew
     *
     * @return Regularisation
     */
    public function setDateNew($dateNew)
    {
        $this->dateNew = $dateNew;

        return $this;
    }

    /**
     * Get dateNew
     *
     * @return \DateTime
     */
    public function getDateNew()
    {
        return $this->dateNew;
    }

    /**
     * Set numNote
     *
     * @param string $numNote
     *
     * @return Regularisation
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
     * @return Regularisation
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
     * Set etatModif
     *
     * @param integer $etatModif
     *
     * @return Regularisation
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
     * @return Regularisation
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
     * Set dateSigneNew
     *
     * @param \DateTime $dateSigneNew
     *
     * @return Regularisation
     */
    public function setDateSigneNew($dateSigneNew)
    {
        $this->dateSigneNew = $dateSigneNew;

        return $this;
    }

    /**
     * Get dateSigneNew
     *
     * @return \DateTime
     */
    public function getDateSigneNew()
    {
        return $this->dateSigneNew;
    }

    /**
     * Set dateNumeriseAutoNew
     *
     * @param \DateTime $dateNumeriseAutoNew
     *
     * @return Regularisation
     */
    public function setDateNumeriseAutoNew($dateNumeriseAutoNew)
    {
        $this->dateNumeriseAutoNew = $dateNumeriseAutoNew;

        return $this;
    }

    /**
     * Get dateNumeriseAutoNew
     *
     * @return \DateTime
     */
    public function getDateNumeriseAutoNew()
    {
        return $this->dateNumeriseAutoNew;
    }

    /**
     * Set matAgentNumerise
     *
     * @param string $matAgentNumerise
     *
     * @return Regularisation
     */
    public function setMatAgentNumerise($matAgentNumerise)
    {
        $this->matAgentNumerise = $matAgentNumerise;

        return $this;
    }

    /**
     * Get matAgentNumerise
     *
     * @return string
     */
    public function getMatAgentNumerise()
    {
        return $this->matAgentNumerise;
    }

    /**
     * Set matAgent
     *
     * @param \Agent\AgentBundle\Entity\Agent $matAgent
     *
     * @return Regularisation
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

    /**
     * Set agent
     *
     * @param \Agent\AgentBundle\Entity\Agent $agent
     *
     * @return Regularisation
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
     * Set pj
     *
     * @param \Agent\AgentBundle\Entity\Document $pj
     *
     * @return Regularisation
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
     * Set matAgentModif
     *
     * @param \Agent\AgentBundle\Entity\Agent $matAgentModif
     *
     * @return Regularisation
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

    /**
     * Set pjNumerise
     *
     * @param \Agent\AgentBundle\Entity\Document $pjNumerise
     *
     * @return Regularisation
     */
    public function setPjNumerise(\Agent\AgentBundle\Entity\Document $pjNumerise = null)
    {
        $this->pjNumerise = $pjNumerise;

        return $this;
    }

    /**
     * Get pjNumerise
     *
     * @return \Agent\AgentBundle\Entity\Document
     */
    public function getPjNumerise()
    {
        return $this->pjNumerise;
    }

    /**
     * Set pjJustificatif
     *
     * @param \Agent\AgentBundle\Entity\Document $pjJustificatif
     *
     * @return Regularisation
     */
    public function setPjJustificatif(\Agent\AgentBundle\Entity\Document $pjJustificatif = null)
    {
        $this->pjJustificatif = $pjJustificatif;

        return $this;
    }

    /**
     * Get pjJustificatif
     *
     * @return \Agent\AgentBundle\Entity\Document
     */
    public function getPjJustificatif()
    {
        return $this->pjJustificatif;
    }

    /**
     * Set etatImprimer
     *
     * @param integer $etatImprimer
     *
     * @return Regularisation
     */
    public function setEtatImprimer($etatImprimer)
    {
        $this->etatImprimer = $etatImprimer;

        return $this;
    }

    /**
     * Get etatImprimer
     *
     * @return integer
     */
    public function getEtatImprimer()
    {
        return $this->etatImprimer;
    }

    /**
     * Set codeDg
     *
     * @param \Agent\AgentBundle\Entity\DirectionGenerale $codeDg
     *
     * @return Regularisation
     */
    public function setCodeDg(\Agent\AgentBundle\Entity\DirectionGenerale $codeDg = null)
    {
        $this->code_dg = $codeDg;

        return $this;
    }

    /**
     * Get codeDg
     *
     * @return \Agent\AgentBundle\Entity\DirectionGenerale
     */
    public function getCodeDg()
    {
        return $this->code_dg;
    }

    /**
     * Set codeSd
     *
     * @param \Agent\AgentBundle\Entity\SousDirection $codeSd
     *
     * @return Regularisation
     */
    public function setCodeSd(\Agent\AgentBundle\Entity\SousDirection $codeSd = null)
    {
        $this->code_sd = $codeSd;

        return $this;
    }

    /**
     * Get codeSd
     *
     * @return \Agent\AgentBundle\Entity\SousDirection
     */
    public function getCodeSd()
    {
        return $this->code_sd;
    }

    /**
     * Set codeSc
     *
     * @param \Agent\AgentBundle\Entity\ServiceDirection $codeSc
     *
     * @return Regularisation
     */
    public function setCodeSc(\Agent\AgentBundle\Entity\ServiceDirection $codeSc = null)
    {
        $this->code_sc = $codeSc;

        return $this;
    }

    /**
     * Get codeSc
     *
     * @return \Agent\AgentBundle\Entity\ServiceDirection
     */
    public function getCodeSc()
    {
        return $this->code_sc;
    }

    /**
     * Set codeDc
     *
     * @param \Agent\AgentBundle\Entity\Direction $codeDc
     *
     * @return Regularisation
     */
    public function setCodeDc(\Agent\AgentBundle\Entity\Direction $codeDc = null)
    {
        $this->code_dc = $codeDc;

        return $this;
    }

    /**
     * Get codeDc
     *
     * @return \Agent\AgentBundle\Entity\Direction
     */
    public function getCodeDc()
    {
        return $this->code_dc;
    }

    /**
     * Set justificaton
     *
     * @param string $justificaton
     *
     * @return Regularisation
     */
    public function setJustificaton($justificaton)
    {
        $this->justificaton = $justificaton;

        return $this;
    }

    /**
     * Get justificaton
     *
     * @return string
     */
    public function getJustificaton()
    {
        return $this->justificaton;
    }
}
