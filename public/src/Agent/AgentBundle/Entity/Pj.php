<?php

namespace Agent\AgentBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Pj
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Entity\PjRepository")
 * @Vich\Uploadable
 */
class Pj extends Assert\File {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     *
     * 
     */
    private $id;


    
    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * @var File
     * @Assert\NotBlank(message="Please, Téléchargement Veuillez spécifier un format de fichier correct svp.")
     * @Assert\File(mimeTypes={"application/pdf"},mimeTypesMessage="le fichier doit être au format PDF")
     * @Vich\UploadableField(mapping="agent_doc", fileNameProperty="imageName")
     */
    private $imageFile;
    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     *
     * @var string
     */
    private $nomOrigine;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     *
     * @var string
     */
    private $uploadReport;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**

     * @ORM\ManyToOne(targetEntity="Users\UsersBundle\Entity\Users", cascade={"persist"})

     * @ORM\JoinColumn(nullable=true)    

     * 

     */
    private $utilisateur;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    public function setImageFile(File $image = null) {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile() {
        return $this->imageFile;
    }



    /**
     * Set nomOrigine
     *
     * @param string $nomOrigine
     *
     * @return Pj
     */
    public function setNomOrigine($nomOrigine)
    {
        $this->nomOrigine = $nomOrigine;

        return $this;
    }

    /**
     * Get nomOrigine
     *
     * @return string
     */
    public function getNomOrigine()
    {
        return $this->nomOrigine;
    }

    /**
     * Set imageName
     *
     * @param string $imageName
     *
     * @return Pj
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Set uploadReport
     *
     * @param string $uploadReport
     *
     * @return Pj
     */
    public function setUploadReport($uploadReport)
    {
        $this->uploadReport = $uploadReport;

        return $this;
    }

    /**
     * Get uploadReport
     *
     * @return string
     */
    public function getUploadReport()
    {
        return $this->uploadReport;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Pj
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set utilisateur
     *
     * @param \Users\UsersBundle\Entity\Users $utilisateur
     *
     * @return Pj
     */
    public function setUtilisateur(\Users\UsersBundle\Entity\Users $utilisateur = null)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \Users\UsersBundle\Entity\Users
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }
}
