<?php

namespace Ediligence\EdiligenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rejet
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ediligence\EdiligenceBundle\Repository\RejetRepository")
 */
class Rejet
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
     * @var \DateTime
     *
     * @ORM\Column(name="DateTraitement", type="datetime", nullable=false)
     */
    private $datetraitement = 'CURRENT_TIMESTAMP';

     /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Pj", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $pjtraitement;

    /**
     * @var string
     *
     * @ORM\Column(name="libTraitement", type="text", length=65535, nullable=false)
     */
    private $libtraitement;

    /**
     * @var string
     *
     * @ORM\Column(name="txtTraitement", type="string", length=50, nullable=false)
     */
    private $txttraitement;

    /**
     * @var integer
     *
     * @ORM\Column(name="EtatTraitement", type="integer", nullable=false)
     */
    private $etattraitement = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="numTraitement", type="integer", nullable=false)
     */
    private $numtraitement;

    /**
     * @var string
     *
     * @ORM\Column(name="matriculeImpute", type="string", length=50, nullable=false)
     */
    private $matriculeimpute;

    /**
     * @var string
     *
     * @ORM\Column(name="matriculeImputeur", type="string", length=50, nullable=false)
     */
    private $matriculeimputeur;

    /**
     * @var integer
     *
     * @ORM\Column(name="CodeCourrier", type="integer", nullable=false)
     */
    private $codecourrier;

    /**
     * @var integer
     *
     * @ORM\Column(name="Id_imput", type="integer", nullable=false)
     */
    private $idImput = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="etataff", type="integer", nullable=false)
     */
    private $etataff = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="modif", type="integer", nullable=false)
     */
    private $modif = '0';
    /**
     * Get id
     *
     * @return integer
     */
    
    /**
     * @ORM\ManyToOne(targetEntity="Ediligence\EdiligenceBundle\Entity\TimputDir", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $imputdir;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Daterejet", type="datetime", nullable=false)
     */
    private $daterejet = 'CURRENT_TIMESTAMP';
    
     /**
     * @var string
     *
     * @ORM\Column(name="matriculecord", type="string", length=50, nullable=false)
     */
    private $matriculecord;
    
    


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
     * Set datetraitement
     *
     * @param \DateTime $datetraitement
     *
     * @return Rejet
     */
    public function setDatetraitement($datetraitement)
    {
        $this->datetraitement = $datetraitement;

        return $this;
    }

    /**
     * Get datetraitement
     *
     * @return \DateTime
     */
    public function getDatetraitement()
    {
        return $this->datetraitement;
    }

    /**
     * Set libtraitement
     *
     * @param string $libtraitement
     *
     * @return Rejet
     */
    public function setLibtraitement($libtraitement)
    {
        $this->libtraitement = $libtraitement;

        return $this;
    }

    /**
     * Get libtraitement
     *
     * @return string
     */
    public function getLibtraitement()
    {
        return $this->libtraitement;
    }

    /**
     * Set txttraitement
     *
     * @param string $txttraitement
     *
     * @return Rejet
     */
    public function setTxttraitement($txttraitement)
    {
        $this->txttraitement = $txttraitement;

        return $this;
    }

    /**
     * Get txttraitement
     *
     * @return string
     */
    public function getTxttraitement()
    {
        return $this->txttraitement;
    }

    /**
     * Set etattraitement
     *
     * @param integer $etattraitement
     *
     * @return Rejet
     */
    public function setEtattraitement($etattraitement)
    {
        $this->etattraitement = $etattraitement;

        return $this;
    }

    /**
     * Get etattraitement
     *
     * @return integer
     */
    public function getEtattraitement()
    {
        return $this->etattraitement;
    }

    /**
     * Set numtraitement
     *
     * @param integer $numtraitement
     *
     * @return Rejet
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
     * Set matriculeimpute
     *
     * @param string $matriculeimpute
     *
     * @return Rejet
     */
    public function setMatriculeimpute($matriculeimpute)
    {
        $this->matriculeimpute = $matriculeimpute;

        return $this;
    }

    /**
     * Get matriculeimpute
     *
     * @return string
     */
    public function getMatriculeimpute()
    {
        return $this->matriculeimpute;
    }

    /**
     * Set matriculeimputeur
     *
     * @param string $matriculeimputeur
     *
     * @return Rejet
     */
    public function setMatriculeimputeur($matriculeimputeur)
    {
        $this->matriculeimputeur = $matriculeimputeur;

        return $this;
    }

    /**
     * Get matriculeimputeur
     *
     * @return string
     */
    public function getMatriculeimputeur()
    {
        return $this->matriculeimputeur;
    }

    /**
     * Set codecourrier
     *
     * @param integer $codecourrier
     *
     * @return Rejet
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
     * Set idImput
     *
     * @param integer $idImput
     *
     * @return Rejet
     */
    public function setIdImput($idImput)
    {
        $this->idImput = $idImput;

        return $this;
    }

    /**
     * Get idImput
     *
     * @return integer
     */
    public function getIdImput()
    {
        return $this->idImput;
    }

    /**
     * Set etataff
     *
     * @param integer $etataff
     *
     * @return Rejet
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
     * Set modif
     *
     * @param integer $modif
     *
     * @return Rejet
     */
    public function setModif($modif)
    {
        $this->modif = $modif;

        return $this;
    }

    /**
     * Get modif
     *
     * @return integer
     */
    public function getModif()
    {
        return $this->modif;
    }

    /**
     * Set daterejet
     *
     * @param \DateTime $daterejet
     *
     * @return Rejet
     */
    public function setDaterejet($daterejet)
    {
        $this->daterejet = $daterejet;

        return $this;
    }

    /**
     * Get daterejet
     *
     * @return \DateTime
     */
    public function getDaterejet()
    {
        return $this->daterejet;
    }

    /**
     * Set matriculecord
     *
     * @param string $matriculecord
     *
     * @return Rejet
     */
    public function setMatriculecord($matriculecord)
    {
        $this->matriculecord = $matriculecord;

        return $this;
    }

    /**
     * Get matriculecord
     *
     * @return string
     */
    public function getMatriculecord()
    {
        return $this->matriculecord;
    }

    /**
     * Set pjtraitement
     *
     * @param \Agent\AgentBundle\Entity\Pj $pjtraitement
     *
     * @return Rejet
     */
    public function setPjtraitement(\Agent\AgentBundle\Entity\Pj $pjtraitement)
    {
        $this->pjtraitement = $pjtraitement;

        return $this;
    }

    /**
     * Get pjtraitement
     *
     * @return \Agent\AgentBundle\Entity\Pj
     */
    public function getPjtraitement()
    {
        return $this->pjtraitement;
    }

    /**
     * Set imputdir
     *
     * @param \Ediligence\EdiligenceBundle\Entity\TimputDir $imputdir
     *
     * @return Rejet
     */
    public function setImputdir(\Ediligence\EdiligenceBundle\Entity\TimputDir $imputdir)
    {
        $this->imputdir = $imputdir;

        return $this;
    }

    /**
     * Get imputdir
     *
     * @return \Ediligence\EdiligenceBundle\Entity\TimputDir
     */
    public function getImputdir()
    {
        return $this->imputdir;
    }
}
