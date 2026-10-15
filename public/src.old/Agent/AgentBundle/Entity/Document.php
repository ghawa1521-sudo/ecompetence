<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Document
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Repository\DocumentRepository")
 * @Vich\Uploadable
 */
class Document {

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
     * @ORM\Column(name="libelle", type="string", length=255, nullable=true)
     */
    private $libelle;

    /**
     * @Vich\UploadableField(mapping="agent_doc" , fileNameProperty="docName")
     *
     * @var file $docFile
     */
    private $docFile;

    /**
     * @var string
     *
     * @ORM\Column(name="agent_doc", type="string", length=255, nullable=true)
     */
    private $agent_doc;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $docName;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedDocAt;

    /**
     * @ORM\ManyToOne(targetEntity="Agent")
     * @ORM\JoinColumn(name="matricule_document", referencedColumnName="id")
     */
    protected $Matricule;
    //1=Note d'affectation
    //2=certificat de prise de servixe
    //0=autres
    /**
     * @var integer
     *
     * @ORM\Column(name="etat", type="integer")
     */
    private $etat = 0;

    public function __construct() {
        $this->updatedDocAt = new \DateTime();
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
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Document
     */
    public function setLibelle($libelle) {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle() {
        return $this->libelle;
    }

    /**
     * Set agentDoc
     *
     * @param string $agentDoc
     *
     * @return Document
     */
    public function setAgentDoc($agentDoc) {
        $this->agent_doc = $agentDoc;

        return $this;
    }

    /**
     * Get agentDoc
     *
     * @return string
     */
    public function getAgentDoc() {
        return $this->agent_doc;
    }

    /**
     * Set docName
     *
     * @param string $docName
     *
     * @return Document
     */
    public function setDocName($docName) {
        $this->docName = $docName;

        return $this;
    }

    /**
     * Get docName
     *
     * @return string
     */
    public function getDocName() {
        return $this->docName;
    }

    /**
     * Set updatedDocAt
     *
     * @param \DateTime $updatedDocAt
     *
     * @return Document
     */
    public function setUpdatedDocAt($updatedDocAt) {
        $this->updatedDocAt = $updatedDocAt;

        return $this;
    }

    /**
     * Get updatedDocAt
     *
     * @return \DateTime
     */
    public function getUpdatedDocAt() {
        return $this->updatedDocAt;
    }

    /**
     * Set matricule
     *
     * @param \Agent\AgentBundle\Entity\Agent $matricule
     *
     * @return Document
     */
    public function setMatricule(\Agent\AgentBundle\Entity\Agent $matricule = null) {
        $this->Matricule = $matricule;

        return $this;
    }

    /**
     * Get matricule
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getMatricule() {
        return $this->Matricule;
    }

    /**
     *
     * @return Document
     */
    public function setDocFile(File $image = null) {
        $this->docFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedDocAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return File
     */
    public function getDocFile() {
        return $this->docFile;
    }

    /**
     * Set etat
     *
     * @param integer $etat
     *
     * @return Document
     */
    public function setEtat($etat) {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return integer
     */
    public function getEtat() {
        return $this->etat;
    }

}
