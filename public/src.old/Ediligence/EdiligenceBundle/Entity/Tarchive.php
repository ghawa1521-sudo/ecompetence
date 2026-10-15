<?php

namespace Ediligence\EdiligenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tarchive
 *
 * @ORM\Table(name="tarchive")
 * @ORM\Entity(repositoryClass="Ediligence\EdiligenceBundle\Repository\TarchiveRepository")
 */
class Tarchive
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_archive", type="datetime", nullable=false)
     */
    private $dateArchive;

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Pj", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $nomFichier;

    /**
     * @var string
     *
     * @ORM\Column(name="Matricule_archiveur", type="string", length=500, nullable=false)
     */
    private $matriculeArchiveur = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="Numtraitement", type="integer", nullable=false)
     */
    private $numtraitement = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="Obsrv", type="string", length=500, nullable=true)
     */
    private $obsrv;

    /**
     * @var string
     *
     * @ORM\Column(name="Service_archive", type="string", length=20, nullable=true)
     */
    private $serviceArchive;

    /**
     * @var integer
     *
     * @ORM\Column(name="CodeCourrier", type="integer", nullable=false)
     */
    private $codecourrier = '0';

    /**
     * @ORM\ManyToOne(targetEntity="Ediligence\EdiligenceBundle\Entity\Ttraitement", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $traitements;

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
     * Set dateArchive
     *
     * @param \DateTime $dateArchive
     *
     * @return Tarchive
     */
    public function setDateArchive($dateArchive)
    {
        $this->dateArchive = $dateArchive;

        return $this;
    }

    /**
     * Get dateArchive
     *
     * @return \DateTime
     */
    public function getDateArchive()
    {
        return $this->dateArchive;
    }

    /**
     * Set matriculeArchiveur
     *
     * @param integer $matriculeArchiveur
     *
     * @return Tarchive
     */
    public function setMatriculeArchiveur($matriculeArchiveur)
    {
        $this->matriculeArchiveur = $matriculeArchiveur;

        return $this;
    }

    /**
     * Get matriculeArchiveur
     *
     * @return integer
     */
    public function getMatriculeArchiveur()
    {
        return $this->matriculeArchiveur;
    }

    /**
     * Set numtraitement
     *
     * @param integer $numtraitement
     *
     * @return Tarchive
     */
    public function setNumtraitement($numtraitement)
    {
        $this->numtraitement = $numtraitement;

        return $this;
    }

    /**
     * Get numtraitement
     *
     * @return integer
     */
    public function getNumtraitement()
    {
        return $this->numtraitement;
    }

    /**
     * Set obsrv
     *
     * @param string $obsrv
     *
     * @return Tarchive
     */
    public function setObsrv($obsrv)
    {
        $this->obsrv = $obsrv;

        return $this;
    }

    /**
     * Get obsrv
     *
     * @return string
     */
    public function getObsrv()
    {
        return $this->obsrv;
    }

    /**
     * Set serviceArchive
     *
     * @param string $serviceArchive
     *
     * @return Tarchive
     */
    public function setServiceArchive($serviceArchive)
    {
        $this->serviceArchive = $serviceArchive;

        return $this;
    }

    /**
     * Get serviceArchive
     *
     * @return string
     */
    public function getServiceArchive()
    {
        return $this->serviceArchive;
    }

    /**
     * Set codecourrier
     *
     * @param integer $codecourrier
     *
     * @return Tarchive
     */
    public function setCodecourrier($codecourrier)
    {
        $this->codecourrier = $codecourrier;

        return $this;
    }

    /**
     * Get codecourrier
     *
     * @return integer
     */
    public function getCodecourrier()
    {
        return $this->codecourrier;
    }

    /**
     * Set nomFichier
     *
     * @param \Agent\AgentBundle\Entity\Pj $nomFichier
     *
     * @return Tarchive
     */
    public function setNomFichier(\Agent\AgentBundle\Entity\Pj $nomFichier)
    {
        $this->nomFichier = $nomFichier;

        return $this;
    }

    /**
     * Get nomFichier
     *
     * @return \Agent\AgentBundle\Entity\Pj
     */
    public function getNomFichier()
    {
        return $this->nomFichier;
    }

    /**
     * Set traitements
     *
     * @param \Ediligence\EdiligenceBundle\Entity\Ttraitement $traitements
     *
     * @return Tarchive
     */
    public function setTraitements(\Ediligence\EdiligenceBundle\Entity\Ttraitement $traitements = null)
    {
        $this->traitements = $traitements;

        return $this;
    }

    /**
     * Get traitements
     *
     * @return \Ediligence\EdiligenceBundle\Entity\Ttraitement
     */
    public function getTraitements()
    {
        return $this->traitements;
    }
}
