<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Agent\AgentBundle\Entity\Agent;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Affecter
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Repository\AffecterRepository")
 */
class Affecter {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=15, nullable=true)
     */
    private $numero;

    /**
     * @var integer
     *
     * @ORM\Column(name="etatAffectation", type="integer")
     */
    private $etatAffectation = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="etatSave", type="integer")
     */
    private $etatSave = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="signeNote", type="integer")
     */
    private $signeNote = 0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateMiseService", type="datetimetz", nullable=true)
     *
     */
    private $dateMiseService; //Date affectation dans un service. au niveau des RHs
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNote", type="date", nullable=true)
     * 
     */
    private $dateNote = NULL;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateprise", type="date", nullable=true)
     * 
     */
    private $dateprise;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCertificat", type="date", nullable=true)
     * 
     */
    private $dateCertificat = NULL;

    /**
     * @var string
     *
     * @ORM\Column(name="numNote", type="string", length=50, nullable=true)
     */
    private $numNote;

    /**
     * @var integer
     *
     * @ORM\Column(name="signeCertificat", type="integer")
     */
    private $signeCertificat = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="numCertificat", type="string", length=50, nullable=true)
     */
    private $numCertificat;

    /**
     * @ORM\OneToOne(targetEntity="Agent", mappedBy="affecter",cascade={"persist"})
     */
    private $agent;

    /**
     * @ORM\ManyToOne(targetEntity="Document", cascade={"persist"})
     * @ORM\JoinColumn(name="id_doc_note", referencedColumnName="id")
     */
    private $documentNote;

    /**
     * @ORM\ManyToOne(targetEntity="Document", cascade={"persist"})
     * @ORM\JoinColumn(name="id_doc_cert", referencedColumnName="id")
     */
    private $documentCertif;

    /**
     * @ORM\ManyToOne(targetEntity="Agent")
     * @ORM\JoinColumn(name="mat_imputer", referencedColumnName="id")
     */
    private $imputer;

    /**
     * @var integer
     *
     * @ORM\Column(name="etatImprimerNote", type="integer")
     */
    private $etatImprimerNote = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="etatImprimerCert", type="integer")
     */
    private $etatImprimerCert = 0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEnregAgt", type="datetime")
     *
     *
     */
    private $dateEnregAgt; //Date enregistrement nouvel Agent

    /**
     * @ORM\ManyToOne(targetEntity="Agent")
     * @ORM\JoinColumn(name="matEnreg", referencedColumnName="id")
     */
    private $matEnreg; //Matricule agent ayant effectué enregistrement nouvel Agent

    /**
     * @ORM\ManyToOne(targetEntity="Agent")
     * @ORM\JoinColumn(name="matMiseService", referencedColumnName="id", nullable=true)
     */
    private $matMiseService; //matricule agent ayant effectué l'application.

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAutoSignNote", type="datetime", nullable=true)
     */
    private $dateAutoSignNote; //date de signature automatique de la note dans le systeme

    /**
     * @ORM\ManyToOne(targetEntity="Agent")
     * @ORM\JoinColumn(name="matSignNote", referencedColumnName="id", nullable=true)
     */
    private $matSignNote; //matricule agent ayant effectue la signature automatique de la note dans le systeme

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAutoPriseSce", type="datetime", nullable=true)
     *
     *
     */
    private $dateAutoPriseSce; //date de validation automatique de la prise de service dans le systeme

    /**
     * @ORM\ManyToOne(targetEntity="Agent")
     * @ORM\JoinColumn(name="matValidPriseSce", referencedColumnName="id", nullable=true)
     */
    private $matValidPriseSce; //matricule agent ayant effectue la validation de la prise de service dans le systeme

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAutoSignCertif", type="datetime", nullable=true)
     *
     *
     */
    private $dateAutoSignCertif; //date de signature automatique du certificat prise de service dans le systeme

    /**
     * @ORM\ManyToOne(targetEntity="Agent")
     * @ORM\JoinColumn(name="matSignCertif", referencedColumnName="id", nullable=true)
     */
    private $matSignCertif; //matricule agent ayant effectue la signature du cert de prise de service dans le systeme

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAutoDemembrement", type="datetime", nullable=true)
     *
     *
     */
    private $dateAutoDemembrement; //date automatique affectation dans le service

    /**
     * @ORM\ManyToOne(targetEntity="Agent")
     * @ORM\JoinColumn(name="matDemembrement", referencedColumnName="id", nullable=true)
     */
    private $matDemembrement; //matricule du SAAF agent ayant effectue l'affectation dans le service
    /**
     * @var integer
     *
     * @ORM\Column(name="etatDemembrement", type="integer")
     */
    private $etatDemembrement = 0;
    public function __construct() {
        $this->dateEnregAgt = new \DateTime('now');
    }

    public function dateCheck($dateprec, $datesuiv) {
        //dump($dateprec);
        // die;
        //dump($dateprec);
        //dump($datesuiv);
        $value = false;

        if ($dateprec == null or $datesuiv == null) {
            $value = true;
        } elseif ($dateprec != null and $datesuiv != null) {

            /* dump($dateprec->diff($datesuiv)->format('%R%a'));
              dump($datesuiv->diff(new \DateTime('now'))->format('%R%a')); */
            //dump($nivo);
            //die;
            if ($this->dateDifference($dateprec, $datesuiv) == true and $this->dateDifference($datesuiv, new \DateTime('now')) == true) {

                $value = true;
                // die;
            }
        }
        return $value;
    }

    public function dateDifference($d1, $d2) {
        $y = false;
        $d1 = new \DateTime($d1->format('y-m-d'));
        $d2 = new \DateTime($d2->format('y-m-d'));
        if ($d1 <= $d2) {
            $y = true;
        }
        return $y;
    }

    //$ok = $dateprec->format('Y-m-d');
    /* dump($dateprec);
      dump($datesuiv);
      die;
      //die;
      if ($dateprec == null and $datesuiv == null) {
      $value = true;
      dump(0);
      } else {
      // dump($ok);
      dump($datesuiv);
      //dump($dateprec->diff($datesuiv)->format('%R%a'));
      //dump($datesuiv->diff(new \Date('now'))->format('%R%a'));
      die;
      if ($dateprec <= $datesuiv and $datesuiv >= new \DateTime('now')) {
      //  dump(1);
      //dump($dateprec);
      //dump($datesuiv);
      //die;
      $value = true;
      } else {
      $value = false;
      //dump(2);
      //dump($dateprec);
      //dump($datesuiv);
      //die;
      }
      }
      dump($value);
      //die;
      return true;
      } */

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set numero
     *
     * @param string $numero
     *
     * @return Affecter
     */
    public function setNumero($numero) {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string
     */
    public function getNumero() {
        return $this->numero;
    }

    /**
     * Set dateprise
     *
     * @param \DateTime $dateprise
     *
     * @return Affecter
     */
    public function setDateprise($dateprise) {
        $this->dateprise = $dateprise;

        return $this;
    }

    /**
     * Get dateprise
     *
     * @return \DateTime
     */
    public function getDateprise() {
        return $this->dateprise;
    }

    /**
     * Set etatAffectation
     *
     * @param integer $etatAffectation
     *
     * @return Affecter
     */
    public function setEtatAffectation($etatAffectation) {
        $this->etatAffectation = $etatAffectation;

        return $this;
    }

    /**
     * Get etatAffectation
     *
     * @return integer
     */
    public function getEtatAffectation() {
        return $this->etatAffectation;
    }

    /**
     * Set etatSave
     *
     * @param integer $etatSave
     *
     * @return Affecter
     */
    public function setEtatSave($etatSave) {
        $this->etatSave = $etatSave;

        return $this;
    }

    /**
     * Get etatSave
     *
     * @return integer
     */
    public function getEtatSave() {
        return $this->etatSave;
    }

    /**
     * Set signeNote
     *
     * @param integer $signeNote
     *
     * @return Affecter
     */
    public function setSigneNote($signeNote) {
        $this->signeNote = $signeNote;

        return $this;
    }

    /**
     * Get signeNote
     *
     * @return integer
     */
    public function getSigneNote() {
        return $this->signeNote;
    }

    /**
     * Set dateNote
     *
     * @param \DateTime $dateNote
     *
     * @return Affecter
     */
    public function setDateNote($dateNote) {
        $this->dateNote = $dateNote;

        return $this;
    }

    /**
     * Get dateNote
     *
     * @return \DateTime
     */
    public function getDateNote() {
        return $this->dateNote;
    }

    /**
     * Set signeCertificat
     *
     * @param integer $signeCertificat
     *
     * @return Affecter
     */
    public function setSigneCertificat($signeCertificat) {
        $this->signeCertificat = $signeCertificat;

        return $this;
    }

    /**
     * Get signeCertificat
     *
     * @return integer
     */
    public function getSigneCertificat() {
        return $this->signeCertificat;
    }

    /**
     * Set dateCertificat
     *
     * @param \DateTime $dateCertificat
     *
     * @return Affecter
     */
    public function setDateCertificat($dateCertificat) {
        $this->dateCertificat = $dateCertificat;

        return $this;
    }

    /**
     * Get dateCertificat
     *
     * @return \DateTime
     */
    public function getDateCertificat() {
        return $this->dateCertificat;
    }

    /**
     * Set agent
     *
     * @param \Agent\AgentBundle\Entity\Agent $agent
     *
     * @return Affecter
     */
    public function setAgent(\Agent\AgentBundle\Entity\Agent $agent = null) {
        $this->agent = $agent;

        return $this;
    }

    /**
     * Get agent
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getAgent() {
        return $this->agent;
    }

    /**
     * Set document
     *
     * @param \Agent\AgentBundle\Entity\Document $document
     *
     * @return Affecter
     */
    public function setDocument(\Agent\AgentBundle\Entity\Document $document = null) {
        $this->document = $document;

        return $this;
    }

    /**
     * Get document
     *
     * @return \Agent\AgentBundle\Entity\Document
     */
    public function getDocument() {
        return $this->document;
    }

    /**
     * Set numNote
     *
     * @param string $numNote
     *
     * @return Affecter
     */
    public function setNumNote($numNote) {
        $this->numNote = $numNote;

        return $this;
    }

    /**
     * Get numNote
     *
     * @return string
     */
    public function getNumNote() {
        return $this->numNote;
    }

    /**
     * Set numCertificat
     *
     * @param string $numCertificat
     *
     * @return Affecter
     */
    public function setNumCertificat($numCertificat) {
        $this->numCertificat = $numCertificat;

        return $this;
    }

    /**
     * Get numCertificat
     *
     * @return string
     */
    public function getNumCertificat() {
        return $this->numCertificat;
    }

    /**
     * Set imputer
     *
     * @param \Agent\AgentBundle\Entity\Agent $imputer
     *
     * @return Affecter
     */
    public function setImputer(\Agent\AgentBundle\Entity\Agent $imputer = null) {
        $this->imputer = $imputer;

        return $this;
    }

    /**
     * Get imputer
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getImputer() {
        return $this->imputer;
    }

    /**
     * Set etatImprimerNote
     *
     * @param integer $etatImprimerNote
     *
     * @return Affecter
     */
    public function setEtatImprimerNote($etatImprimerNote) {
        $this->etatImprimerNote = $etatImprimerNote;

        return $this;
    }

    /**
     * Get etatImprimerNote
     *
     * @return integer
     */
    public function getEtatImprimerNote() {
        return $this->etatImprimerNote;
    }

    /**
     * Set etatImprimerCert
     *
     * @param integer $etatImprimerCert
     *
     * @return Affecter
     */
    public function setEtatImprimerCert($etatImprimerCert) {
        $this->etatImprimerCert = $etatImprimerCert;

        return $this;
    }

    /**
     * Get etatImprimerCert
     *
     * @return integer
     */
    public function getEtatImprimerCert() {
        return $this->etatImprimerCert;
    }

    /**
     * Set datecreation
     *
     * @param \DateTime $datecreation
     *
     * @return Affecter
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
     * Set dateEnregAgt
     *
     * @param \DateTime $dateEnregAgt
     *
     * @return Affecter
     */
    public function setDateEnregAgt($dateEnregAgt) {
        $this->dateEnregAgt = $dateEnregAgt;

        return $this;
    }

    /**
     * Get dateEnregAgt
     *
     * @return \DateTime
     */
    public function getDateEnregAgt() {
        return $this->dateEnregAgt;
    }

    /**
     * Set dateMiseService
     *
     * @param \DateTime $dateMiseService
     *
     * @return Affecter
     */
    public function setDateMiseService($dateMiseService) {
        $this->dateMiseService = $dateMiseService;

        return $this;
    }

    /**
     * Get dateMiseService
     *
     * @return \DateTime
     */
    public function getDateMiseService() {
        return $this->dateMiseService;
    }

    /**
     * Set dateAutoSignNote
     *
     * @param \DateTime $dateAutoSignNote
     *
     * @return Affecter
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
     * Set dateAutoPriseSce
     *
     * @param \DateTime $dateAutoPriseSce
     *
     * @return Affecter
     */
    public function setDateAutoPriseSce($dateAutoPriseSce) {
        $this->dateAutoPriseSce = $dateAutoPriseSce;

        return $this;
    }

    /**
     * Get dateAutoPriseSce
     *
     * @return \DateTime
     */
    public function getDateAutoPriseSce() {
        return $this->dateAutoPriseSce;
    }

    /**
     * Set dateAutoSignCertif
     *
     * @param \DateTime $dateAutoSignCertif
     *
     * @return Affecter
     */
    public function setDateAutoSignCertif($dateAutoSignCertif) {
        $this->dateAutoSignCertif = $dateAutoSignCertif;

        return $this;
    }

    /**
     * Get dateAutoSignCertif
     *
     * @return \DateTime
     */
    public function getDateAutoSignCertif() {
        return $this->dateAutoSignCertif;
    }

    /**
     * Set matEnreg
     *
     * @param \Agent\AgentBundle\Entity\Agent $matEnreg
     *
     * @return Affecter
     */
    public function setMatEnreg(\Agent\AgentBundle\Entity\Agent $matEnreg = null) {
        $this->matEnreg = $matEnreg;

        return $this;
    }

    /**
     * Get matEnreg
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getMatEnreg() {
        return $this->matEnreg;
    }

    /**
     * Set matMiseService
     *
     * @param \Agent\AgentBundle\Entity\Agent $matMiseService
     *
     * @return Affecter
     */
    public function setMatMiseService(\Agent\AgentBundle\Entity\Agent $matMiseService = null) {
        $this->matMiseService = $matMiseService;

        return $this;
    }

    /**
     * Get matMiseService
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getMatMiseService() {
        return $this->matMiseService;
    }

    /**
     * Set matSignNote
     *
     * @param \Agent\AgentBundle\Entity\Agent $matSignNote
     *
     * @return Affecter
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
     * Set matValidPriseSce
     *
     * @param \Agent\AgentBundle\Entity\Agent $matValidPriseSce
     *
     * @return Affecter
     */
    public function setMatValidPriseSce(\Agent\AgentBundle\Entity\Agent $matValidPriseSce = null) {
        $this->matValidPriseSce = $matValidPriseSce;

        return $this;
    }

    /**
     * Get matValidPriseSce
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getMatValidPriseSce() {
        return $this->matValidPriseSce;
    }

    /**
     * Set matSignCertif
     *
     * @param \Agent\AgentBundle\Entity\Agent $matSignCertif
     *
     * @return Affecter
     */
    public function setMatSignCertif(\Agent\AgentBundle\Entity\Agent $matSignCertif = null) {
        $this->matSignCertif = $matSignCertif;

        return $this;
    }

    /**
     * Get matSignCertif
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getMatSignCertif() {
        return $this->matSignCertif;
    }

    /**
     * Set documentNote
     *
     * @param \Agent\AgentBundle\Entity\Document $documentNote
     *
     * @return Affecter
     */
    public function setDocumentNote(\Agent\AgentBundle\Entity\Document $documentNote = null) {
        $this->documentNote = $documentNote;

        return $this;
    }

    /**
     * Get documentNote
     *
     * @return \Agent\AgentBundle\Entity\Document
     */
    public function getDocumentNote() {
        return $this->documentNote;
    }

    /**
     * Set documentCertif
     *
     * @param \Agent\AgentBundle\Entity\Document $documentCertif
     *
     * @return Affecter
     */
    public function setDocumentCertif(\Agent\AgentBundle\Entity\Document $documentCertif = null) {
        $this->documentCertif = $documentCertif;

        return $this;
    }

    /**
     * Get documentCertif
     *
     * @return \Agent\AgentBundle\Entity\Document
     */
    public function getDocumentCertif() {
        return $this->documentCertif;
    }


    /**
     * Set dateAutoDemembrement
     *
     * @param \DateTime $dateAutoDemembrement
     *
     * @return Affecter
     */
    public function setDateAutoDemembrement($dateAutoDemembrement)
    {
        $this->dateAutoDemembrement = $dateAutoDemembrement;

        return $this;
    }

    /**
     * Get dateAutoDemembrement
     *
     * @return \DateTime
     */
    public function getDateAutoDemembrement()
    {
        return $this->dateAutoDemembrement;
    }

    /**
     * Set etatDemembrement
     *
     * @param integer $etatDemembrement
     *
     * @return Affecter
     */
    public function setEtatDemembrement($etatDemembrement)
    {
        $this->etatDemembrement = $etatDemembrement;

        return $this;
    }

    /**
     * Get etatDemembrement
     *
     * @return integer
     */
    public function getEtatDemembrement()
    {
        return $this->etatDemembrement;
    }

    /**
     * Set matDemembrement
     *
     * @param \Agent\AgentBundle\Entity\Agent $matDemembrement
     *
     * @return Affecter
     */
    public function setMatDemembrement(\Agent\AgentBundle\Entity\Agent $matDemembrement = null)
    {
        $this->matDemembrement = $matDemembrement;

        return $this;
    }

    /**
     * Get matDemembrement
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getMatDemembrement()
    {
        return $this->matDemembrement;
    }
}
