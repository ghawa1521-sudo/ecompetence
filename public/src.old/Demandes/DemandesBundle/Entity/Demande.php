<?php

namespace Demandes\DemandesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Demande
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Demandes\DemandesBundle\Repository\DemandeRepository")
 */
class Demande {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
////////////////////////////////////////////////////// OBJETS AGISSANT DANS LA GESTION DES DEMANDES
    ///////////////////////////////////
    /**
     * @ORM\ManyToOne(targetEntity="TypeDemande",  cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeDemande;

    /**
     * @var string
     *
     * @ORM\Column(name="objet", type="text",nullable=true)
     */
    private $objet;

    /**
     * @var string
     *
     * @ORM\Column(name="motif_rejet", type="text",nullable=true)
     */
    private $motifRejet;

    /**
     * @var string
     *
     * @ORM\Column(name="destination", type="text",nullable=true)
     * @Assert\Expression("this.checkDest()", message="Renseignez une destination SVP!")
     */
    private $destination;

    /**
     * @var string
     *
     * @ORM\Column(name="dateDeb", type="datetime",nullable=true)
     * @Assert\Expression("this.checkDate()", message="Cette date n'est pas valide")
     */
    private $dateDeb;

    /**
     * @var string
     * @Assert\Expression("this.checkDate()", message="Cette date n'est pas valide")
     * @ORM\Column(name="dateFin", type="datetime",nullable=true)
     */
    private $dateFin;
////////////////////////////////////////////////////// OBJETS de type Agent Agissant dans l'émission la transmission et validation des demandes
///////////////////////////////////EMMETEUR DE LA DEMANDE
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecreation", type="datetime")
     *
     *
     */
    private $datecreation;

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent",  cascade={"persist"})
     * @ORM\JoinColumn(name="emmeteur", referencedColumnName="id")
     */
    private $emmeteur;  ///////Emmétteur de la demande.

    /**
     * @var integer
     *
     * @ORM\Column(name="etatEmmission", type="integer")
     */
    private $etatEmmission; //Etat de l'émission de la demande par l'émmetteur

    /**
     * @var integer
     *
     * @ORM\Column(name="etatNotifcation", type="integer")
     */
    private $etatNotification; //Etat de la notification de la demande 0 afficher; 1 ne pas afficher
///////////////////////////////////SUPERIEUR DIRECT 1
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateRepSupDir", type="datetime",nullable=true)
     */
    private $dateRepSupDir; ///////Récepteur et Supérieur Direct de l'émmetteur

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent",  cascade={"persist"})
     * @ORM\JoinColumn(name="SupDir", referencedColumnName="id",nullable=true)
     */
    private $SupDir;  ///////Supérieur Direct de l'émmetteur

    /**
     * @var integer
     *
     * @ORM\Column(name="etatRepSupDir", type="integer",nullable=true)
     */
    private $etatRepSupDir; //Etat de la reception de la demande par le supérieur hiérarchique
///////////////////////////////////SUPERIEUR DIRECT 2
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateRepSupDir2", type="datetime",nullable=true)
     */
    private $dateRepSupDir2; ///////Récepteur et Supérieur Direct de l'émmetteur

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent",  cascade={"persist"})
     * @ORM\JoinColumn(name="SupDir2", referencedColumnName="id",nullable=true)
     */
    private $SupDir2;  ///////Supérieur Direct de l'émmetteur

    /**
     * @var integer
     *
     * @ORM\Column(name="etatRepSupDir2", type="integer",nullable=true)
     */
    private $etatRepSupDir2; //Etat de la reception de la demande par le supérieur hiérarchique
///////////////////////////////////RESSOURCES HUMAINES
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateRepGrh", type="datetime",nullable=true)
     */
    private $dateRepGrh; ///////Récepteur et Supérieur Direct de l'émmetteur

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent",  cascade={"persist"})
     * @ORM\JoinColumn(name="grh", referencedColumnName="id",nullable=true)
     */
    private $Grh;  ///////Supérieur Direct de l'émmetteur

    /**
     * @var integer
     *
     * @ORM\Column(name="etatRepGrh", type="integer",nullable=true)
     */
    private $etatRepGrh; //Etat de la reception de la demande par le supérieur hiérarchique

    /**
     * @var integer
     *
     * @ORM\Column(name="etatEncours", type="integer",nullable=true)
     */
    private $etatEncours = 0;
//////////////////////////////////////////////////////////
    /**
     * @var integer
     *
     * @ORM\Column(name="etatArchive", type="integer",nullable=true)
     */
    private $etatArchive = 0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNumActe", type="date", nullable=true)
     * @Assert\LessThanOrEqual(
     *      value = "today",
     *      message = "la date de signature ne peut pas être ultérieur à aujourd'hui"
     * )
     *  @Assert\Expression(
     *     "this.testDate() <= value",
     *     message="la date de signature ne peut pas être antérieur à la date de validation de la demande"
     * )
     */
    private $dateNumActe = NULL;

    /**
     * @var string
     *
     * @ORM\Column(name="numActe", type="string", length=15, nullable=true)
     */
    private $numActe;

    /**
     * @var integer
     *
     * @ORM\Column(name="signeActe", type="integer")
     */
    private $signeActe = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="etatVal", type="integer")
     */
    private $etatVal = 0;

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Document", cascade={"persist"})
     * @ORM\JoinColumn(name="id_demande_note", referencedColumnName="id")
     */
    private $demandeActe;

    /**
     * @ORM\OneToOne(targetEntity="Agent\AgentBundle\Entity\Avis", mappedBy="demande")
     * @ORM\JoinColumn(nullable=true)
     */
    private $avis;

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent")
     * @ORM\JoinColumn(name="matValidSup1", referencedColumnName="id", nullable=true)
     */
    private $matValidSup1;

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent")
     * @ORM\JoinColumn(name="matValidSup2", referencedColumnName="id", nullable=true)
     */
    private $matValidSup2;

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent")
     * @ORM\JoinColumn(name="matValidRh", referencedColumnName="id", nullable=true)
     */
    private $matValidRh;

    /**
     * @var integer
     *
     * @ORM\Column(name="Interim", type="integer")
     */
    private $etatInterim = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="etatDeleguation", type="integer")
     */
    private $etatDeleguation = 0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAutoSignNote", type="datetime", nullable=true)
     */
    private $dateAutoSignNote; //date de signature automatique de la note dans le systeme

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent")
     * @ORM\JoinColumn(name="matSignNote", referencedColumnName="id", nullable=true)
     */
    private $matSignNote; //matricule agent ayant effectue la signature automatique de la note dans le systeme

    /**
     * @var integer
     *
     * @ORM\Column(name="etatImpression", type="integer",options={"default":1})
     */
    private $etatImpression = 1;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbrecopie", type="integer", nullable=true)
     */
    private $nbrecopie = 0; //nbre de copie

    /**
     * @ORM\ManyToOne(targetEntity="Demandes\DemandesBundle\Entity\Positionnement", inversedBy="demande",cascade={"persist"})
     * @ORM\JoinColumn(name="positionnement", referencedColumnName="id", nullable=true)
     */
    private $positionnement;

 /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Pj", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $piecejointe = NULL;
///
   

    public function checkDate() {
        $value = true;
        //$dDiff = $this->getDateDeb()->diff($this->getDateFin());
        //$dDiff->format('%R');
        //$dDiff->days;

        if (($this->getDateDeb() == null or $this->getDateFin() == null) and $this->getTypeDemande()->getId() == 1) {
            $value = false;
        }elseif(($this->getDateDeb() == null) and $this->getTypeDemande()->getId() == 6 ){
           $value = false; 
        }elseif(($this->getDateDeb() == null or $this->getDateFin() == null) and $this->getTypeDemande()->getId() == 7 ){
           $value = false; 
        }
        return $value;
    }

    public function checkDest() {
        $value = true;
        if ($this->getDestination() == null and $this->getTypeDemande() and $this->getTypeDemande()->getId() == 1) {
            $value = false;
        }
        return $value;
    }

    public function testDate() {
        if ($this->dateRepGrh) {
            return $this->dateRepGrh->setTime(0, 0, 0);
        } else {
            return $this->dateRepGrh;
        }
    }

    public function __construct() {
        $this->datecreation = new \DateTime();
    }

///////////////////////////////////////////////////////////

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set objet
     *
     * @param string $objet
     *
     * @return Demande
     */
    public function setObjet($objet) {
        $this->objet = $objet;

        return $this;
    }

    /**
     * Get objet
     *
     * @return string
     */
    public function getObjet() {
        return $this->objet;
    }

    /**
     * Set motifRejet
     *
     * @param string $motifRejet
     *
     * @return Demande
     */
    public function setMotifRejet($motifRejet) {
        $this->motifRejet = $motifRejet;

        return $this;
    }

    /**
     * Get motifRejet
     *
     * @return string
     */
    public function getMotifRejet() {
        return $this->motifRejet;
    }

    /**
     * Set destination
     *
     * @param string $destination
     *
     * @return Demande
     */
    public function setDestination($destination) {
        $this->destination = $destination;

        return $this;
    }

    /**
     * Get destination
     *
     * @return string
     */
    public function getDestination() {
        return $this->destination;
    }

    /**
     * Set dateDeb
     *
     * @param \DateTime $dateDeb
     *
     * @return Demande
     */
    public function setDateDeb($dateDeb) {
        $this->dateDeb = $dateDeb;

        return $this;
    }

    /**
     * Get dateDeb
     *
     * @return \DateTime
     */
    public function getDateDeb() {
        return $this->dateDeb;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return Demande
     */
    public function setDateFin($dateFin) {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin() {
        return $this->dateFin;
    }

    /**
     * Set datecreation
     *
     * @param \DateTime $datecreation
     *
     * @return Demande
     */
    public function setDatecreation($datecreation) {
        $this->datecreation = $datecreation;

        return $this;
    }

    /**
     * Get datecreation
     *
     * @return \DateTime
     */
    public function getDatecreation() {
        return $this->datecreation;
    }

    /**
     * Set etatEmmission
     *
     * @param integer $etatEmmission
     *
     * @return Demande
     */
    public function setEtatEmmission($etatEmmission) {
        $this->etatEmmission = $etatEmmission;

        return $this;
    }

    /**
     * Get etatEmmission
     *
     * @return integer
     */
    public function getEtatEmmission() {
        return $this->etatEmmission;
    }

    /**
     * Set etatNotification
     *
     * @param integer $etatNotification
     *
     * @return Demande
     */
    public function setEtatNotification($etatNotification) {
        $this->etatNotification = $etatNotification;

        return $this;
    }

    /**
     * Get etatNotification
     *
     * @return integer
     */
    public function getEtatNotification() {
        return $this->etatNotification;
    }

    /**
     * Set dateRepSupDir
     *
     * @param \DateTime $dateRepSupDir
     *
     * @return Demande
     */
    public function setDateRepSupDir($dateRepSupDir) {
        $this->dateRepSupDir = $dateRepSupDir;

        return $this;
    }

    /**
     * Get dateRepSupDir
     *
     * @return \DateTime
     */
    public function getDateRepSupDir() {
        return $this->dateRepSupDir;
    }

    /**
     * Set etatRepSupDir
     *
     * @param integer $etatRepSupDir
     *
     * @return Demande
     */
    public function setEtatRepSupDir($etatRepSupDir) {
        $this->etatRepSupDir = $etatRepSupDir;

        return $this;
    }

    /**
     * Get etatRepSupDir
     *
     * @return integer
     */
    public function getEtatRepSupDir() {
        return $this->etatRepSupDir;
    }

    /**
     * Set dateRepSupDir2
     *
     * @param \DateTime $dateRepSupDir2
     *
     * @return Demande
     */
    public function setDateRepSupDir2($dateRepSupDir2) {
        $this->dateRepSupDir2 = $dateRepSupDir2;

        return $this;
    }

    /**
     * Get dateRepSupDir2
     *
     * @return \DateTime
     */
    public function getDateRepSupDir2() {
        return $this->dateRepSupDir2;
    }

    /**
     * Set etatRepSupDir2
     *
     * @param integer $etatRepSupDir2
     *
     * @return Demande
     */
    public function setEtatRepSupDir2($etatRepSupDir2) {
        $this->etatRepSupDir2 = $etatRepSupDir2;

        return $this;
    }

    /**
     * Get etatRepSupDir2
     *
     * @return integer
     */
    public function getEtatRepSupDir2() {
        return $this->etatRepSupDir2;
    }

    /**
     * Set dateRepGrh
     *
     * @param \DateTime $dateRepGrh
     *
     * @return Demande
     */
    public function setDateRepGrh($dateRepGrh) {
        $this->dateRepGrh = $dateRepGrh;

        return $this;
    }

    /**
     * Get dateRepGrh
     *
     * @return \DateTime
     */
    public function getDateRepGrh() {
        return $this->dateRepGrh;
    }

    /**
     * Set etatRepGrh
     *
     * @param integer $etatRepGrh
     *
     * @return Demande
     */
    public function setEtatRepGrh($etatRepGrh) {
        $this->etatRepGrh = $etatRepGrh;

        return $this;
    }

    /**
     * Get etatRepGrh
     *
     * @return integer
     */
    public function getEtatRepGrh() {
        return $this->etatRepGrh;
    }

    /**
     * Set etatEncours
     *
     * @param integer $etatEncours
     *
     * @return Demande
     */
    public function setEtatEncours($etatEncours) {
        $this->etatEncours = $etatEncours;

        return $this;
    }

    /**
     * Get etatEncours
     *
     * @return integer
     */
    public function getEtatEncours() {
        return $this->etatEncours;
    }

    /**
     * Set etatArchive
     *
     * @param integer $etatArchive
     *
     * @return Demande
     */
    public function setEtatArchive($etatArchive) {
        $this->etatArchive = $etatArchive;

        return $this;
    }

    /**
     * Get etatArchive
     *
     * @return integer
     */
    public function getEtatArchive() {
        return $this->etatArchive;
    }

    /**
     * Set dateNumActe
     *
     * @param \DateTime $dateNumActe
     *
     * @return Demande
     */
    public function setDateNumActe($dateNumActe) {
        $this->dateNumActe = $dateNumActe;

        return $this;
    }

    /**
     * Get dateNumActe
     *
     * @return \DateTime
     */
    public function getDateNumActe() {
        return $this->dateNumActe;
    }

    /**
     * Set numActe
     *
     * @param string $numActe
     *
     * @return Demande
     */
    public function setNumActe($numActe) {
        $this->numActe = $numActe;

        return $this;
    }

    /**
     * Get numActe
     *
     * @return string
     */
    public function getNumActe() {
        return $this->numActe;
    }

    /**
     * Set signeActe
     *
     * @param integer $signeActe
     *
     * @return Demande
     */
    public function setSigneActe($signeActe) {
        $this->signeActe = $signeActe;

        return $this;
    }

    /**
     * Get signeActe
     *
     * @return integer
     */
    public function getSigneActe() {
        return $this->signeActe;
    }

    /**
     * Set typeDemande
     *
     * @param \Demandes\DemandesBundle\Entity\TypeDemande $typeDemande
     *
     * @return Demande
     */
    public function setTypeDemande(\Demandes\DemandesBundle\Entity\TypeDemande $typeDemande) {
        $this->typeDemande = $typeDemande;

        return $this;
    }

    /**
     * Get typeDemande
     *
     * @return \Demandes\DemandesBundle\Entity\TypeDemande
     */
    public function getTypeDemande() {
        return $this->typeDemande;
    }

    /**
     * Set emmeteur
     *
     * @param \Agent\AgentBundle\Entity\Agent $emmeteur
     *
     * @return Demande
     */
    public function setEmmeteur(\Agent\AgentBundle\Entity\Agent $emmeteur = null) {
        $this->emmeteur = $emmeteur;

        return $this;
    }

    /**
     * Get emmeteur
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getEmmeteur() {
        return $this->emmeteur;
    }

    /**
     * Set supDir
     *
     * @param \Agent\AgentBundle\Entity\Agent $supDir
     *
     * @return Demande
     */
    public function setSupDir(\Agent\AgentBundle\Entity\Agent $supDir = null) {
        $this->SupDir = $supDir;

        return $this;
    }

    /**
     * Get supDir
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getSupDir() {
        return $this->SupDir;
    }

    /**
     * Set supDir2
     *
     * @param \Agent\AgentBundle\Entity\Agent $supDir2
     *
     * @return Demande
     */
    public function setSupDir2(\Agent\AgentBundle\Entity\Agent $supDir2 = null) {
        $this->SupDir2 = $supDir2;

        return $this;
    }

    /**
     * Get supDir2
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getSupDir2() {
        return $this->SupDir2;
    }

    /**
     * Set grh
     *
     * @param \Agent\AgentBundle\Entity\Agent $grh
     *
     * @return Demande
     */
    public function setGrh(\Agent\AgentBundle\Entity\Agent $grh = null) {
        $this->Grh = $grh;

        return $this;
    }

    /**
     * Get grh
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getGrh() {
        return $this->Grh;
    }

    /**
     * Set demandeActe
     *
     * @param \Agent\AgentBundle\Entity\Document $demandeActe
     *
     * @return Demande
     */
    public function setDemandeActe(\Agent\AgentBundle\Entity\Document $demandeActe = null) {
        $this->demandeActe = $demandeActe;

        return $this;
    }

    /**
     * Get demandeActe
     *
     * @return \Agent\AgentBundle\Entity\Document
     */
    public function getDemandeActe() {
        return $this->demandeActe;
    }

    /**
     * Set etatVal
     *
     * @param integer $etatVal
     *
     * @return Demande
     */
    public function setEtatVal($etatVal) {
        $this->etatVal = $etatVal;

        return $this;
    }

    /**
     * Get etatVal
     *
     * @return integer
     */
    public function getEtatVal() {
        return $this->etatVal;
    }

    /**
     * Set avis
     *
     * @param \Agent\AgentBundle\Entity\Avis $avis
     *
     * @return Demande
     */
    public function setAvis(\Agent\AgentBundle\Entity\Avis $avis = null) {
        $this->avis = $avis;

        return $this;
    }

    /**
     * Get avis
     *
     * @return \Agent\AgentBundle\Entity\Avis
     */
    public function getAvis() {
        return $this->avis;
    }

    /**
     * Set etatInterim
     *
     * @param integer $etatInterim
     *
     * @return Demande
     */
    public function setEtatInterim($etatInterim) {
        $this->etatInterim = $etatInterim;

        return $this;
    }

    /**
     * Get etatInterim
     *
     * @return integer
     */
    public function getEtatInterim() {
        return $this->etatInterim;
    }

    /**
     * Set matValidSup1
     *
     * @param \Agent\AgentBundle\Entity\Agent $matValidSup1
     *
     * @return Demande
     */
    public function setMatValidSup1(\Agent\AgentBundle\Entity\Agent $matValidSup1 = null) {
        $this->matValidSup1 = $matValidSup1;

        return $this;
    }

    /**
     * Get matValidSup1
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getMatValidSup1() {
        return $this->matValidSup1;
    }

    /**
     * Set matValidSup2
     *
     * @param \Agent\AgentBundle\Entity\Agent $matValidSup2
     *
     * @return Demande
     */
    public function setMatValidSup2(\Agent\AgentBundle\Entity\Agent $matValidSup2 = null) {
        $this->matValidSup2 = $matValidSup2;

        return $this;
    }

    /**
     * Get matValidSup2
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getMatValidSup2() {
        return $this->matValidSup2;
    }

    /**
     * Set matValidRh
     *
     * @param \Agent\AgentBundle\Entity\Agent $matValidRh
     *
     * @return Demande
     */
    public function setMatValidRh(\Agent\AgentBundle\Entity\Agent $matValidRh = null) {
        $this->matValidRh = $matValidRh;

        return $this;
    }

    /**
     * Get matValidRh
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getMatValidRh() {
        return $this->matValidRh;
    }

    /**
     * Set etatDeleguation
     *
     * @param integer $etatDeleguation
     *
     * @return Demande
     */
    public function setEtatDeleguation($etatDeleguation) {
        $this->etatDeleguation = $etatDeleguation;

        return $this;
    }

    /**
     * Get etatDeleguation
     *
     * @return integer
     */
    public function getEtatDeleguation() {
        return $this->etatDeleguation;
    }

    /**
     * Set dateAutoSignNote
     *
     * @param \DateTime $dateAutoSignNote
     *
     * @return Demande
     */
    public function setDateAutoSignNote($dateAutoSignNote) {
        $this->dateAutoSignNote = $dateAutoSignNote;

        return $this;
    }

    /**
     * Get dateAutoSignNote
     *
     * @return \DateTime
     */
    public function getDateAutoSignNote() {
        return $this->dateAutoSignNote;
    }

    /**
     * Set matSignNote
     *
     * @param \Agent\AgentBundle\Entity\Agent $matSignNote
     *
     * @return Demande
     */
    public function setMatSignNote(\Agent\AgentBundle\Entity\Agent $matSignNote = null) {
        $this->matSignNote = $matSignNote;

        return $this;
    }

    /**
     * Get matSignNote
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getMatSignNote() {
        return $this->matSignNote;
    }

    /**
     * Set etatImpression
     *
     * @param integer $etatImpression
     *
     * @return Demande
     */
    public function setEtatImpression($etatImpression) {
        $this->etatImpression = $etatImpression;

        return $this;
    }

    /**
     * Get etatImpression
     *
     * @return integer
     */
    public function getEtatImpression() {
        return $this->etatImpression;
    }

    /**
     * Set nbrecopie
     *
     * @param integer $nbrecopie
     *
     * @return Demande
     */
    public function setNbrecopie($nbrecopie) {
        $this->nbrecopie = $nbrecopie;

        return $this;
    }

    /**
     * Get nbrecopie
     *
     * @return integer
     */
    public function getNbrecopie() {
        return $this->nbrecopie;
    }

    /**
     * Set positionnement
     *
     * @param \Demandes\DemandesBundle\Entity\Positionnement $positionnement
     *
     * @return Demande
     */
    public function setPositionnement(\Demandes\DemandesBundle\Entity\Positionnement $positionnement = null) {
        $this->positionnement = $positionnement;

        return $this;
    }

    /**
     * Get positionnement
     *
     * @return \Demandes\DemandesBundle\Entity\Positionnement
     */
    public function getPositionnement() {
        return $this->positionnement;
    }


    /**
     * Set piecejointe
     *
     * @param \Agent\AgentBundle\Entity\Pj $piecejointe
     *
     * @return Demande
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
}
