<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Mutation
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Repository\MutationRepository")
 */
class Mutation {

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
     * @var integer
     *
     * @ORM\Column(name="etatMutation", type="integer",nullable=true)
     */
    private $etatMutation = 0; //Etat de la reception de la demande par le supérieur

    /**
     * @var integer
     *
     * @ORM\Column(name="TypeMutation", type="integer",nullable=true)
     */
    private $TypeMutation; //1=effectuer par l'agent; 2=effectuer directement par le DG.
    /**
     * @var string
     *
     * @ORM\Column(name="Observ", type="string", length=255,nullable=true)
     */
    private $Observ;

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Direction",  cascade={"persist"})
     * @ORM\JoinColumn(name="destination", referencedColumnName="id")
     */
    private $destination;

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Direction",  cascade={"persist"})
     * @ORM\JoinColumn(name="origine", referencedColumnName="id")
     */
    private $origine;

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent",  cascade={"persist"})
     * @ORM\JoinColumn(name="emmeteur", referencedColumnName="id")
     */
    private $emmeteur;

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
    private $etatRepSupDir = 0;

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
     * @var \DateTime
     *
     * @ORM\Column(name="dateRepDest", type="datetime",nullable=true)
     */
    private $dateRepDest; ///////Récepteur et Supérieur Direct de l'émmetteur

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent",  cascade={"persist"})
     * @ORM\JoinColumn(name="supDest", referencedColumnName="id",nullable=true)
     */
    private $supDest;  ///////Supérieur Direct de l'émmetteur

    /**
     * @var integer
     *
     * @ORM\Column(name="etatRepDest", type="integer",nullable=true)
     */
    private $etatRepDest = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="etatRepGrh", type="integer",nullable=true)
     */
    private $etatRepGrh = 0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNoteMutation", type="date", nullable=true)
     * @Assert\LessThanOrEqual(
     *      value = "today",
     *      message = "la date de signature ne peut pas être ultérieur à aujourdhui"
     * )
     *  @Assert\Expression(
     *     "this.testDate() <= value",
     *     message="la date de signature ne peut pas être antérieur à la date de validation de la mutation"
     * )
     */
    private $dateNoteMutation = NULL;

    /**
     * @var string
     *
     * @ORM\Column(name="numNote", type="string", length=15, nullable=true)
     */
    private $numNote;

    /**
     * @var integer
     *
     * @ORM\Column(name="signeNote", type="integer")
     */
    private $signeNote = 0;

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Document", cascade={"persist"})
     * @ORM\JoinColumn(name="id_mutation_note", referencedColumnName="id")
     */
    private $mutationNote;
    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent",  cascade={"persist"})
     * @ORM\JoinColumn(name="matValidDest", referencedColumnName="id",nullable=true)
     */
    private $matValidDest;  ///////Supérieur destination de l'émmetteur

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent",  cascade={"persist"})
     * @ORM\JoinColumn(name="matValidSupDir", referencedColumnName="id",nullable=true)
     */
    private $matValidSupDir;  ///////Supérieur Direct de l'émmetteur

     /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent",  cascade={"persist"})
     * @ORM\JoinColumn(name="matValidGrh", referencedColumnName="id",nullable=true)
     */
    private $matValidGrh;

    public function __construct() {
        $this->dateCreation = new \DateTime();
    }
    public function testDate(){
        if($this->dateRepGrh){
            return $this->dateRepGrh->setTime(0, 0, 0);
        }else{
            return $this->dateRepGrh;
        }
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Mutation
     */
    public function setDateCreation($dateCreation) {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation() {
        return $this->dateCreation;
    }

    /**
     * Set etatMutation
     *
     * @param integer $etatMutation
     *
     * @return Mutation
     */
    public function setEtatMutation($etatMutation) {
        $this->etatMutation = $etatMutation;

        return $this;
    }

    /**
     * Get etatMutation
     *
     * @return integer
     */
    public function getEtatMutation() {
        return $this->etatMutation;
    }

    /**
     * Set typeMutation
     *
     * @param integer $typeMutation
     *
     * @return Mutation
     */
    public function setTypeMutation($typeMutation) {
        $this->TypeMutation = $typeMutation;

        return $this;
    }

    /**
     * Get typeMutation
     *
     * @return integer
     */
    public function getTypeMutation() {
        return $this->TypeMutation;
    }

    /**
     * Set observ
     *
     * @param string $observ
     *
     * @return Mutation
     */
    public function setObserv($observ) {
        $this->Observ = $observ;

        return $this;
    }

    /**
     * Get observ
     *
     * @return string
     */
    public function getObserv() {
        return $this->Observ;
    }

    /**
     * Set dateRepSupDir
     *
     * @param \DateTime $dateRepSupDir
     *
     * @return Mutation
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
     * @return Mutation
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
     * Set dateRepGrh
     *
     * @param \DateTime $dateRepGrh
     *
     * @return Mutation
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
     * Set dateRepDest
     *
     * @param \DateTime $dateRepDest
     *
     * @return Mutation
     */
    public function setDateRepDest($dateRepDest) {
        $this->dateRepDest = $dateRepDest;

        return $this;
    }

    /**
     * Get dateRepDest
     *
     * @return \DateTime
     */
    public function getDateRepDest() {
        return $this->dateRepDest;
    }

    /**
     * Set etatRepDest
     *
     * @param integer $etatRepDest
     *
     * @return Mutation
     */
    public function setEtatRepDest($etatRepDest) {
        $this->etatRepDest = $etatRepDest;

        return $this;
    }

    /**
     * Get etatRepDest
     *
     * @return integer
     */
    public function getEtatRepDest() {
        return $this->etatRepDest;
    }

    /**
     * Set etatRepGrh
     *
     * @param integer $etatRepGrh
     *
     * @return Mutation
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
     * Set destination
     *
     * @param \Agent\AgentBundle\Entity\Direction $destination
     *
     * @return Mutation
     */
    public function setDestination(\Agent\AgentBundle\Entity\Direction $destination = null) {
        $this->destination = $destination;

        return $this;
    }

    /**
     * Get destination
     *
     * @return \Agent\AgentBundle\Entity\Direction
     */
    public function getDestination() {
        return $this->destination;
    }

    /**
     * Set emmeteur
     *
     * @param \Agent\AgentBundle\Entity\Agent $emmeteur
     *
     * @return Mutation
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
     * @return Mutation
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
     * Set grh
     *
     * @param \Agent\AgentBundle\Entity\Agent $grh
     *
     * @return Mutation
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
     * Set supDest
     *
     * @param \Agent\AgentBundle\Entity\Agent $supDest
     *
     * @return Mutation
     */
    public function setSupDest(\Agent\AgentBundle\Entity\Agent $supDest = null) {
        $this->supDest = $supDest;

        return $this;
    }

    /**
     * Get supDest
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getSupDest() {
        return $this->supDest;
    }

    /**
     * Set origine
     *
     * @param \Agent\AgentBundle\Entity\Direction $origine
     *
     * @return Mutation
     */
    public function setOrigine(\Agent\AgentBundle\Entity\Direction $origine = null) {
        $this->origine = $origine;

        return $this;
    }

    /**
     * Get origine
     *
     * @return \Agent\AgentBundle\Entity\Direction
     */
    public function getOrigine() {
        return $this->origine;
    }

    /**
     * Set dateNoteMutation
     *
     * @param \DateTime $dateNoteMutation
     *
     * @return Mutation
     */
    public function setDateNoteMutation($dateNoteMutation) {
        $this->dateNoteMutation = $dateNoteMutation;

        return $this;
    }

    /**
     * Get dateNoteMutation
     *
     * @return \DateTime
     */
    public function getDateNoteMutation() {
        return $this->dateNoteMutation;
    }

    /**
     * Set numNote
     *
     * @param string $numNote
     *
     * @return Mutation
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
     * Set etatNote
     *
     * @param integer $etatNote
     *
     * @return Mutation
     */
    public function setEtatNote($etatNote) {
        $this->etatNote = $etatNote;

        return $this;
    }

    /**
     * Get etatNote
     *
     * @return integer
     */
    public function getEtatNote() {
        return $this->etatNote;
    }

    /**
     * Set mutationNote
     *
     * @param \Agent\AgentBundle\Entity\Document $mutationNote
     *
     * @return Mutation
     */
    public function setMutationNote(\Agent\AgentBundle\Entity\Document $mutationNote = null) {
        $this->mutationNote = $mutationNote;

        return $this;
    }

    /**
     * Get mutationNote
     *
     * @return \Agent\AgentBundle\Entity\Document
     */
    public function getMutationNote() {
        return $this->mutationNote;
    }

    /**
     * Set signeNote
     *
     * @param integer $signeNote
     *
     * @return Mutation
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
     * Set matValidDest
     *
     * @param \Agent\AgentBundle\Entity\Agent $matValidDest
     *
     * @return Mutation
     */
    public function setMatValidDest(\Agent\AgentBundle\Entity\Agent $matValidDest = null)
    {
        $this->matValidDest = $matValidDest;

        return $this;
    }

    /**
     * Get matValidDest
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getMatValidDest()
    {
        return $this->matValidDest;
    }

    /**
     * Set matValidSupDir
     *
     * @param \Agent\AgentBundle\Entity\Agent $matValidSupDir
     *
     * @return Mutation
     */
    public function setMatValidSupDir(\Agent\AgentBundle\Entity\Agent $matValidSupDir = null)
    {
        $this->matValidSupDir = $matValidSupDir;

        return $this;
    }

    /**
     * Get matValidSupDir
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getMatValidSupDir()
    {
        return $this->matValidSupDir;
    }

    /**
     * Set matValidGrh
     *
     * @param \Agent\AgentBundle\Entity\Agent $matValidGrh
     *
     * @return Mutation
     */
    public function setMatValidGrh(\Agent\AgentBundle\Entity\Agent $matValidGrh = null)
    {
        $this->matValidGrh = $matValidGrh;

        return $this;
    }

    /**
     * Get matValidGrh
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getMatValidGrh()
    {
        return $this->matValidGrh;
    }
}
