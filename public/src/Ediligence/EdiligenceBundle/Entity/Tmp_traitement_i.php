<?php

namespace Ediligence\EdiligenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tmp_traitement_i
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ediligence\EdiligenceBundle\Repository\Tmp_traitement_iRepository")
 */
class Tmp_traitement_i
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
     * @ORM\ManyToOne(targetEntity="Ediligence\EdiligenceBundle\Entity\TimputDir_i", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $imputdir;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Daterejet", type="datetime", nullable=true)
     */
    private $daterejet = null;
    
     /**
     * @var string
     *
     * @ORM\Column(name="matriculecord", type="string", length=50, nullable=true)
     */
    private $matriculecord;
    
    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Pj", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $pjrejet;
    
    /**
     * @var string
     *
     * @ORM\Column(name="librejet", type="text", length=65535, nullable=true)
     */
    private $librejet;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="desactive", type="integer", nullable=false)
     */
    private $desactive = '0';
    

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
     * @return Tmp_traitement_i
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
     * @return Tmp_traitement_i
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
     * @return Tmp_traitement_i
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
     * @return Tmp_traitement_i
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
     * @return Tmp_traitement_i
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
     * @return Tmp_traitement_i
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
     * @return Tmp_traitement_i
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
     * @return Tmp_traitement_i
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
     * @return Tmp_traitement_i
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
     * @return Tmp_traitement_i
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
     * @return Tmp_traitement_i
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
     * @return Tmp_traitement_i
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
     * @return Tmp_traitement_i
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
     * Set librejet
     *
     * @param string $librejet
     *
     * @return Tmp_traitement_i
     */
    public function setLibrejet($librejet)
    {
        $this->librejet = $librejet;

        return $this;
    }

    /**
     * Get librejet
     *
     * @return string
     */
    public function getLibrejet()
    {
        return $this->librejet;
    }

    /**
     * Set pjtraitement
     *
     * @param \Agent\AgentBundle\Entity\Pj $pjtraitement
     *
     * @return Tmp_traitement_i
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
     * @param \Ediligence\EdiligenceBundle\Entity\TimputDir_i $imputdir
     *
     * @return Tmp_traitement_i
     */
    public function setImputdir(\Ediligence\EdiligenceBundle\Entity\TimputDir_i $imputdir)
    {
        $this->imputdir = $imputdir;

        return $this;
    }

    /**
     * Get imputdir
     *
     * @return \Ediligence\EdiligenceBundle\Entity\TimputDir_i
     */
    public function getImputdir()
    {
        return $this->imputdir;
    }

    /**
     * Set pjrejet
     *
     * @param \Agent\AgentBundle\Entity\Pj $pjrejet
     *
     * @return Tmp_traitement_i
     */
    public function setPjrejet(\Agent\AgentBundle\Entity\Pj $pjrejet = null)
    {
        $this->pjrejet = $pjrejet;

        return $this;
    }

    /**
     * Get pjrejet
     *
     * @return \Agent\AgentBundle\Entity\Pj
     */
    public function getPjrejet()
    {
        return $this->pjrejet;
    }
    
    /**
     * Set desactive
     *
     * @param integer $desactive
     *
     * @return Tmp_traitement_i
     */
    public function setDesactive($desactive)
    {
        $this->desactive = $desactive;

        return $this;
    }

    /**
     * Get desactive
     *
     * @return integer
     */
    public function getDesactive()
    {
        return $this->desactive;
    }

}
