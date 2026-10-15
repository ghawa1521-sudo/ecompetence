<?php

namespace Ediligence\EdiligenceBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tcourrier
 *
 * @ORM\Table(name="tcourrier")
 * @ORM\Entity(repositoryClass="Ediligence\EdiligenceBundle\Repository\TcourrierRepository")
 * @UniqueEntity(fields={"exercice","numenregistrement"},
 *                       errorPath="numenregistrement",
 *                       message="Ce numéro est déjà utilisé pour cette année",)
 */
class Tcourrier {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="refOrigine", type="string", length=30, nullable=true)
     */
    private $reforigine;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateOrigine", type="date", nullable=false,nullable=true)
     */
    private $dateorigine;

    /**
     * @var integer
     *
     * @ORM\Column(name="NumEnregistrement", type="integer", nullable=false,unique=true)
     * 
     */
    private $numenregistrement;

    /**
     * @var string
     *
     * @ORM\Column(name="Objet",  type="text", nullable=false, length=65535)
     */
    private $objet;

    /**
     * @var string
     *
     * @ORM\Column(name="ObservationScecour", type="text", length=50, nullable=false)
     */
    private $observationscecour;

   /**
     * @ORM\ManyToOne(targetEntity="Texpediteur", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $adresseenreg ;

    /**
     * @var integer
     *
     * @ORM\Column(name="CodeTypeCour", type="integer", nullable=false)
     */
    private $codetypecour = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="etatCourrier", type="integer", nullable=false)
     */
    private $etatcourrier = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="codNatCour", type="integer", nullable=false)
     */
    private $codnatcour = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="exercice", type="integer", nullable=false)
     */
    private $exercice = '2017';

    /**
     * @var integer
     *
     * @ORM\Column(name="etataff", type="integer", nullable=false)
     */
    private $etataff = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="id_cord", type="integer", nullable=true)
     */
    private $idCord;

    /**
     * @var string
     *
     * @ORM\Column(name="id_invits", type="string", length=25, nullable=true)
     */
    private $idInvits=null;

    /**
     * @var string
     *
     * @ORM\Column(name="Id_identifiant", type="string", length=25, nullable=false)
     */
    private $idIdentifiant = null;

    /**
     * @var string
     *
     * @ORM\Column(name="NumEnregistrements", type="string", length=150, nullable=true)
     */
    private $numenregistrements;

    /**
     * @ORM\ManyToOne(targetEntity="Tprovenance", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    
    private $sourceCour;

    
    /**
     * @var string
     *
     * @ORM\Column(name="Dest_cour", type="string", length=20, nullable=true)
     */
    private $destCour;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_CREAT", type="datetime", nullable=true)
     */
    private $dateCreat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_MODIF", type="datetime", nullable=true)
     */
    private $dateModif;

    /**
     * @var integer
     *
     * @ORM\Column(name="Etat_reception", type="integer", nullable=false)
     */
    private $etatReception = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="etat_alert", type="integer", nullable=false)
     */
    private $etatAlert = '0';

    /**
     * @ORM\ManyToOne(targetEntity="Ttypecourrier", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $typecourrier;

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Pj", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $piecejointe;
    
    /**
     * @ORM\ManyToOne(targetEntity="Texterieur", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $texterieur;
    
    /**
     * @var string
     *
     * @ORM\Column(name="Servicesaisi", type="string", length=20, nullable=true)
     */
    private $servicesaisi;
    
    /**
     * @ORM\Column(name="Departdest", type="string", length=300, nullable=true)
     */
    private $departdest;
    
    public function __construct()
    {
        $this->dateCreat = new \DateTime();
    }
    
    public function __toString()
    {
        return $this->getsourceCour();
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
     * Set reforigine
     *
     * @param string $reforigine
     *
     * @return Tcourrier
     */
    public function setReforigine($reforigine)
    {
        $this->reforigine = $reforigine;

        return $this;
    }

    /**
     * Get reforigine
     *
     * @return string
     */
    public function getReforigine()
    {
        return $this->reforigine;
    }

    /**
     * Set dateorigine
     *
     * @param \DateTime $dateorigine
     *
     * @return Tcourrier
     */
    public function setDateorigine($dateorigine)
    {
        $this->dateorigine = $dateorigine;

        return $this;
    }

    /**
     * Get dateorigine
     *
     * @return \DateTime
     */
    public function getDateorigine()
    {
        return $this->dateorigine;
    }

    /**
     * Set numenregistrement
     *
     * @param integer $numenregistrement
     *
     * @return Tcourrier
     */
    public function setNumenregistrement($numenregistrement)
    {
        $this->numenregistrement = $numenregistrement;

        return $this;
    }

    /**
     * Get numenregistrement
     *
     * @return integer
     */
    public function getNumenregistrement()
    {
        return $this->numenregistrement;
    }

    /**
     * Set objet
     *
     * @param string $objet
     *
     * @return Tcourrier
     */
    public function setObjet($objet)
    {
        $this->objet = $objet;

        return $this;
    }

    /**
     * Get objet
     *
     * @return string
     */
    public function getObjet()
    {
        return $this->objet;
    }

    /**
     * Set observationscecour
     *
     * @param string $observationscecour
     *
     * @return Tcourrier
     */
    public function setObservationscecour($observationscecour)
    {
        $this->observationscecour = $observationscecour;

        return $this;
    }

    /**
     * Get observationscecour
     *
     * @return string
     */
    public function getObservationscecour()
    {
        return $this->observationscecour;
    }

    /**
     * Set codetypecour
     *
     * @param integer $codetypecour
     *
     * @return Tcourrier
     */
    public function setCodetypecour($codetypecour)
    {
        $this->codetypecour = $codetypecour;

        return $this;
    }

    /**
     * Get codetypecour
     *
     * @return integer
     */
    public function getCodetypecour()
    {
        return $this->codetypecour;
    }

    /**
     * Set etatcourrier
     *
     * @param integer $etatcourrier
     *
     * @return Tcourrier
     */
    public function setEtatcourrier($etatcourrier)
    {
        $this->etatcourrier = $etatcourrier;

        return $this;
    }

    /**
     * Get etatcourrier
     *
     * @return integer
     */
    public function getEtatcourrier()
    {
        return $this->etatcourrier;
    }

    /**
     * Set codnatcour
     *
     * @param integer $codnatcour
     *
     * @return Tcourrier
     */
    public function setCodnatcour($codnatcour)
    {
        $this->codnatcour = $codnatcour;

        return $this;
    }

    /**
     * Get codnatcour
     *
     * @return integer
     */
    public function getCodnatcour()
    {
        return $this->codnatcour;
    }

    /**
     * Set exercice
     *
     * @param integer $exercice
     *
     * @return Tcourrier
     */
    public function setExercice($exercice)
    {
        $this->exercice = $exercice;

        return $this;
    }

    /**
     * Get exercice
     *
     * @return integer
     */
    public function getExercice()
    {
        return $this->exercice;
    }

    /**
     * Set etataff
     *
     * @param integer $etataff
     *
     * @return Tcourrier
     */
    public function setEtataff($etataff)
    {
        $this->etataff = $etataff;

        return $this;
    }

    /**
     * Get etataff
     *
     * @return integer
     */
    public function getEtataff()
    {
        return $this->etataff;
    }

    /**
     * Set idCord
     *
     * @param integer $idCord
     *
     * @return Tcourrier
     */
    public function setIdCord($idCord)
    {
        $this->idCord = $idCord;

        return $this;
    }

    /**
     * Get idCord
     *
     * @return integer
     */
    public function getIdCord()
    {
        return $this->idCord;
    }

    /**
     * Set idInvits
     *
     * @param string $idInvits
     *
     * @return Tcourrier
     */
    public function setIdInvits($idInvits)
    {
        $this->idInvits = $idInvits;

        return $this;
    }

    /**
     * Get idInvits
     *
     * @return string
     */
    public function getIdInvits()
    {
        return $this->idInvits;
    }

    /**
     * Set idIdentifiant
     *
     * @param string $idIdentifiant
     *
     * @return Tcourrier
     */
    public function setIdIdentifiant($idIdentifiant)
    {
        $this->idIdentifiant = $idIdentifiant;

        return $this;
    }

    /**
     * Get idIdentifiant
     *
     * @return string
     */
    public function getIdIdentifiant()
    {
        return $this->idIdentifiant;
    }

    /**
     * Set numenregistrements
     *
     * @param string $numenregistrements
     *
     * @return Tcourrier
     */
    public function setNumenregistrements($numenregistrements)
    {
        $this->numenregistrements = $numenregistrements;

        return $this;
    }

    /**
     * Get numenregistrements
     *
     * @return string
     */
    public function getNumenregistrements()
    {
        return $this->numenregistrements;
    }

    /**
     * Set destCour
     *
     * @param string $destCour
     *
     * @return Tcourrier
     */
    public function setDestCour($destCour)
    {
        $this->destCour = $destCour;

        return $this;
    }

    /**
     * Get destCour
     *
     * @return string
     */
    public function getDestCour()
    {
        return $this->destCour;
    }

    /**
     * Set dateCreat
     *
     * @param \DateTime $dateCreat
     *
     * @return Tcourrier
     */
    public function setDateCreat($dateCreat)
    {
        $this->dateCreat = $dateCreat;

        return $this;
    }

    /**
     * Get dateCreat
     *
     * @return \DateTime
     */
    public function getDateCreat()
    {
        return $this->dateCreat;
    }

    /**
     * Set dateModif
     *
     * @param \DateTime $dateModif
     *
     * @return Tcourrier
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
     * Set etatReception
     *
     * @param integer $etatReception
     *
     * @return Tcourrier
     */
    public function setEtatReception($etatReception)
    {
        $this->etatReception = $etatReception;

        return $this;
    }

    /**
     * Get etatReception
     *
     * @return integer
     */
    public function getEtatReception()
    {
        return $this->etatReception;
    }

    /**
     * Set etatAlert
     *
     * @param integer $etatAlert
     *
     * @return Tcourrier
     */
    public function setEtatAlert($etatAlert)
    {
        $this->etatAlert = $etatAlert;

        return $this;
    }

    /**
     * Get etatAlert
     *
     * @return integer
     */
    public function getEtatAlert()
    {
        return $this->etatAlert;
    }

    /**
     * Set adresseenreg
     *
     * @param \Ediligence\EdiligenceBundle\Entity\Texpediteur $adresseenreg
     *
     * @return Tcourrier
     */
    public function setAdresseenreg(\Ediligence\EdiligenceBundle\Entity\Texpediteur $adresseenreg = null)
    {
        $this->adresseenreg = $adresseenreg;

        return $this;
    }

    /**
     * Get adresseenreg
     *
     * @return \Ediligence\EdiligenceBundle\Entity\Texpediteur
     */
    public function getAdresseenreg()
    {
        return $this->adresseenreg;
    }

    /**
     * Set sourceCour
     *
     * @param \Ediligence\EdiligenceBundle\Entity\Tprovenance $sourceCour
     *
     * @return Tcourrier
     */
    public function setSourceCour(\Ediligence\EdiligenceBundle\Entity\Tprovenance $sourceCour = null)
    {
        $this->sourceCour = $sourceCour;

        return $this;
    }

    /**
     * Get sourceCour
     *
     * @return \Ediligence\EdiligenceBundle\Entity\Tprovenance
     */
    public function getSourceCour()
    {
        return $this->sourceCour;
    }

    /**
     * Set typecourrier
     *
     * @param \Ediligence\EdiligenceBundle\Entity\Ttypecourrier $typecourrier
     *
     * @return Tcourrier
     */
    public function setTypecourrier(\Ediligence\EdiligenceBundle\Entity\Ttypecourrier $typecourrier)
    {
        $this->typecourrier = $typecourrier;

        return $this;
    }

    /**
     * Get typecourrier
     *
     * @return \Ediligence\EdiligenceBundle\Entity\Ttypecourrier
     */
    public function getTypecourrier()
    {
        return $this->typecourrier;
    }

    /**
     * Set piecejointe
     *
     * @param \Agent\AgentBundle\Entity\Pj $piecejointe
     *
     * @return Tcourrier
     */
    public function setPiecejointe(\Agent\AgentBundle\Entity\Pj $piecejointe = null)
    {
        $this->piecejointe = $piecejointe;

        return $this;
    }

    /**
     * Get piecejointe
     *
     * @return \Agent\AgentBundle\Entity\Pj
     */
    public function getPiecejointe()
    {
        return $this->piecejointe;
    }

    /**
     * Set texterieur
     *
     * @param \Ediligence\EdiligenceBundle\Entity\Texterieur $texterieur
     *
     * @return Tcourrier
     */
    public function setTexterieur(\Ediligence\EdiligenceBundle\Entity\Texterieur $texterieur)
    {
        $this->texterieur = $texterieur;

        return $this;
    }

    /**
     * Get texterieur
     *
     * @return \Ediligence\EdiligenceBundle\Entity\Texterieur
     */
    public function getTexterieur()
    {
        return $this->texterieur;
    }
    
    /**
     * Set servicesaisi
     *
     * @param string $servicesaisi
     *
     * @return Tcourrier
     */
    public function setServicesaisi($servicesaisi)
    {
        $this->servicesaisi = $servicesaisi;

        return $this;
    }
    
    /**
     * Getservicesaisi
     *
     * @return string
     */
    public function getServicesaisi()
    {
        return $this->servicesaisi;
    }

    
     /**
     * Set Departdest
     *
     * @param string $departdest
     *
     * @return Tcourrier
     */
    
    public function setDepartdest($departdest)
    {
        $this->departdest = $departdest;

        return $this;
    }
    
    /**
     * Getdepartdest
     *
     * @return string
     */
    public function getDepartdest()
    {
        return $this->departdest;
    }
    
    /**
     * Getdepartdest
     *
     * @return string
     */
    public function getDepartdestList()
    {
        return explode(',',$this->getDepartdest());
    }

    
}
