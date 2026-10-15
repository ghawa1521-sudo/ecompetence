<?php

namespace Demandes\DemandesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Positionnement
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Positionnement
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
     * @ORM\JoinColumn(name="direction", referencedColumnName="id", nullable=true)
     */
    private $Direction;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecreation", type="datetime")
     */
    private $datecreation;


    /**
     * @ORM\OneToMany(targetEntity="Demandes\DemandesBundle\Entity\Demande", mappedBy="positionnement")
     */
    private $demande; 

    /**
     * @ORM\OneToMany(targetEntity="Agent\AgentBundle\Entity\Conges", mappedBy="positionnement")
     */
    private $conges; 

    

    
   
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->demande = new \Doctrine\Common\Collections\ArrayCollection();
        $this->conges = new \Doctrine\Common\Collections\ArrayCollection();
        $this->datecreation = new \DateTime();
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
     * @return Positionnement
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
     * Set codeDg
     *
     * @param \Agent\AgentBundle\Entity\DirectionGenerale $codeDg
     *
     * @return Positionnement
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
     * @return Positionnement
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
     * @return Positionnement
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
     * Add demande
     *
     * @param \Demandes\DemandesBundle\Entity\Demande $demande
     *
     * @return Positionnement
     */
    public function addDemande(\Demandes\DemandesBundle\Entity\Demande $demande)
    {
        $this->demande[] = $demande;

        return $this;
    }

    /**
     * Remove demande
     *
     * @param \Demandes\DemandesBundle\Entity\Demande $demande
     */
    public function removeDemande(\Demandes\DemandesBundle\Entity\Demande $demande)
    {
        $this->demande->removeElement($demande);
    }

    /**
     * Get demande
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDemande()
    {
        return $this->demande;
    }

    /**
     * Add conge
     *
     * @param \Agent\AgentBundle\Entity\Conges $conge
     *
     * @return Positionnement
     */
    public function addConge(\Agent\AgentBundle\Entity\Conges $conge)
    {
        $this->conges[] = $conge;

        return $this;
    }

    /**
     * Remove conge
     *
     * @param \Agent\AgentBundle\Entity\Conges $conge
     */
    public function removeConge(\Agent\AgentBundle\Entity\Conges $conge)
    {
        $this->conges->removeElement($conge);
    }

    /**
     * Get conges
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConges()
    {
        return $this->conges;
    }

    /**
     * Set direction
     *
     * @param \Agent\AgentBundle\Entity\Direction $direction
     *
     * @return Positionnement
     */
    public function setDirection(\Agent\AgentBundle\Entity\Direction $direction = null)
    {
        $this->Direction = $direction;

        return $this;
    }

    /**
     * Get direction
     *
     * @return \Agent\AgentBundle\Entity\Direction
     */
    public function getDirection()
    {
        return $this->Direction;
    }
}
