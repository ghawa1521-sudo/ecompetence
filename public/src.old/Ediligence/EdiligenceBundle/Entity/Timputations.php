<?php

namespace Ediligence\EdiligenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Timputations
 *
 * @ORM\Table(name="timputations")
 * @ORM\Entity(repositoryClass="Ediligence\EdiligenceBundle\Repository\TimputationsRepository")
 */
#, indexes={@ORM\Index(name="Matricule_imput", columns={"Matricule_imput"}), @ORM\Index(name="Service_imput", columns={"Service_imput"}), @ORM\Index(name="Code_courrier", columns={"Code_courrier"}), @ORM\Index(name="Coordinateur", columns={"Coordinateur"})}
class Timputations {

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_imput", type="datetime", nullable=false)
     */
    private $dateImput;

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent",  cascade={"persist"})
     * @ORM\JoinColumn(name="Imputmatricule", referencedColumnName="id", nullable=true)
     */
    private $matriculeImput;

    /**
     * @var string
     *
     * @ORM\Column(name="Service_imput", type="string", length=20, nullable=false)
     */
    private $serviceImput;

    
    /**
     * @var string
     *
     * @ORM\Column(name="Priorite_imput", type="string", length=100, nullable=false)
     */
    private $prioriteImput;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Delai_imput", type="datetime", nullable=false)
     */
    private $delaiImput;

    /**
     * @var string
     *
     * @ORM\Column(name="Coordinateur", type="string", length=20, nullable=false)
     */
    private $coordinateur;

    /**
     * @var string
     *
     * @ORM\Column(name="Inst_part", type="string", length=500, nullable=true)
     */
    private $instPart;

    /**
     * @var integer
     *
     * @ORM\Column(name="Etat_imput", type="integer", nullable=false)
     */
    private $etatImput = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="Etat_trait", type="integer", nullable=false)
     */
    private $etatTrait = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="Nbre_pers", type="integer", nullable=false)
     */
    private $nbrePers = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Tcourrier", cascade="persist")
     * @ORM\JoinColumn(nullable=false)
     */
    private $courrier;

     /**
     * @ORM\OneToMany(targetEntity="TimputDir",mappedBy="imputation")
     */
    private $imputdir;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->imputdir = new \Doctrine\Common\Collections\ArrayCollection();
    }

    

    /**
     * Set dateImput
     *
     * @param \DateTime $dateImput
     *
     * @return Timputations
     */
    public function setDateImput($dateImput)
    {
        $this->dateImput = $dateImput;

        return $this;
    }

    /**
     * Get dateImput
     *
     * @return \DateTime
     */
    public function getDateImput()
    {
        return $this->dateImput;
    }

    /**
     * Set serviceImput
     *
     * @param string $serviceImput
     *
     * @return Timputations
     */
    public function setServiceImput($serviceImput)
    {
        $this->serviceImput = $serviceImput;

        return $this;
    }

    /**
     * Get serviceImput
     *
     * @return string
     */
    public function getServiceImput()
    {
        return $this->serviceImput;
    }

    /**
     * Set prioriteImput
     *
     * @param string $prioriteImput
     *
     * @return Timputations
     */
    public function setPrioriteImput($prioriteImput)
    {
        $this->prioriteImput = $prioriteImput;

        return $this;
    }

    /**
     * Get prioriteImput
     *
     * @return string
     */
    public function getPrioriteImput()
    {
        return $this->prioriteImput;
    }

    /**
     * Set delaiImput
     *
     * @param \DateTime $delaiImput
     *
     * @return Timputations
     */
    public function setDelaiImput($delaiImput)
    {
        $this->delaiImput = $delaiImput;

        return $this;
    }

    /**
     * Get delaiImput
     *
     * @return \DateTime
     */
    public function getDelaiImput()
    {
        return $this->delaiImput;
    }

    /**
     * Set coordinateur
     *
     * @param string $coordinateur
     *
     * @return Timputations
     */
    public function setCoordinateur($coordinateur)
    {
        $this->coordinateur = $coordinateur;

        return $this;
    }

    /**
     * Get coordinateur
     *
     * @return string
     */
    public function getCoordinateur()
    {
        return $this->coordinateur;
    }

    /**
     * Set instPart
     *
     * @param string $instPart
     *
     * @return Timputations
     */
    public function setInstPart($instPart)
    {
        $this->instPart = $instPart;

        return $this;
    }

    /**
     * Get instPart
     *
     * @return string
     */
    public function getInstPart()
    {
        return $this->instPart;
    }

    /**
     * Set etatImput
     *
     * @param integer $etatImput
     *
     * @return Timputations
     */
    public function setEtatImput($etatImput)
    {
        $this->etatImput = $etatImput;

        return $this;
    }

    /**
     * Get etatImput
     *
     * @return integer
     */
    public function getEtatImput()
    {
        return $this->etatImput;
    }

    /**
     * Set etatTrait
     *
     * @param integer $etatTrait
     *
     * @return Timputations
     */
    public function setEtatTrait($etatTrait)
    {
        $this->etatTrait = $etatTrait;

        return $this;
    }

    /**
     * Get etatTrait
     *
     * @return integer
     */
    public function getEtatTrait()
    {
        return $this->etatTrait;
    }

    /**
     * Set nbrePers
     *
     * @param integer $nbrePers
     *
     * @return Timputations
     */
    public function setNbrePers($nbrePers)
    {
        $this->nbrePers = $nbrePers;

        return $this;
    }

    /**
     * Get nbrePers
     *
     * @return integer
     */
    public function getNbrePers()
    {
        return $this->nbrePers;
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
     * Set matriculeImput
     *
     * @param \Agent\AgentBundle\Entity\Agent $matriculeImput
     *
     * @return Timputations
     */
    public function setMatriculeImput(\Agent\AgentBundle\Entity\Agent $matriculeImput = null)
    {
        $this->matriculeImput = $matriculeImput;

        return $this;
    }

    /**
     * Get matriculeImput
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getMatriculeImput()
    {
        return $this->matriculeImput;
    }

    /**
     * Set courrier
     *
     * @param \Ediligence\EdiligenceBundle\Entity\Tcourrier $courrier
     *
     * @return Timputations
     */
    public function setCourrier(\Ediligence\EdiligenceBundle\Entity\Tcourrier $courrier)
    {
        $this->courrier = $courrier;

        return $this;
    }

    /**
     * Get courrier
     *
     * @return \Ediligence\EdiligenceBundle\Entity\Tcourrier
     */
    public function getCourrier()
    {
        return $this->courrier;
    }

    /**
     * Add imputdir
     *
     * @param \Ediligence\EdiligenceBundle\Entity\TimputDir $imputdir
     *
     * @return Timputations
     */
    public function addImputdir(\Ediligence\EdiligenceBundle\Entity\TimputDir $imputdir)
    {
        $this->imputdir[] = $imputdir;

        return $this;
    }

    /**
     * Remove imputdir
     *
     * @param \Ediligence\EdiligenceBundle\Entity\TimputDir $imputdir
     */
    public function removeImputdir(\Ediligence\EdiligenceBundle\Entity\TimputDir $imputdir)
    {
        $this->imputdir->removeElement($imputdir);
    }

    /**
     * Get imputdir
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImputdir()
    {
        return $this->imputdir;
    }
    
    
}
