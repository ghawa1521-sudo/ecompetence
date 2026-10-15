<?php

namespace Ediligence\EdiligenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TimputDir_i
 *
 * @ORM\Table(name="timput_dir_i", indexes={@ORM\Index(name="id", columns={"id"}), @ORM\Index(name="Service_imput", columns={"Service_imput"})})
 * @ORM\Entity(repositoryClass="Ediligence\EdiligenceBundle\Repository\TimputDir_iRepository")
 */
class TimputDir_i {
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Timputations_i", cascade="persist", inversedBy="imputdir_i")
     * @ORM\JoinColumn(nullable=false)
     */

    private $imputation;

    /**
     * @var string
     *
     * @ORM\Column(name="Service_imput", type="string", length=20, nullable=false)
     */
    private $serviceImput;

    /**
     * @var integer
     *
     * @ORM\Column(name="Imput_matricule", type="string", nullable=false)
     */
    private $imputMatricule = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="Etat_imput_dir", type="integer", nullable=false)
     */
    private $etatImputDir = '0';

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent",  cascade={"persist"})
     * @ORM\JoinColumn(name="matriculeimpute", referencedColumnName="id", nullable=true)
     */
    
    private $matriculeimpute;
   
    /**
     * @var integer
     *
     * @ORM\Column(name="desactive", type="integer", nullable=false)
     */
    private $desactive = '0';
    
    
    public function __toString() {
        return $this->getId().'';
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
     * Set serviceImput
     *
     * @param string $serviceImput
     *
     * @return TimputDir_i
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
     * Set imputMatricule
     *
     * @param string $imputMatricule
     *
     * @return TimputDir_i
     */
    public function setImputMatricule($imputMatricule)
    {
        $this->imputMatricule = $imputMatricule;

        return $this;
    }

    /**
     * Get imputMatricule
     *
     * @return string
     */
    public function getImputMatricule()
    {
        return $this->imputMatricule;
    }

    /**
     * Set etatImputDir
     *
     * @param integer $etatImputDir
     *
     * @return TimputDir_i
     */
    public function setEtatImputDir($etatImputDir)
    {
        $this->etatImputDir = $etatImputDir;

        return $this;
    }

    /**
     * Get etatImputDir
     *
     * @return integer
     */
    public function getEtatImputDir()
    {
        return $this->etatImputDir;
    }

    /**
     * Set desactive
     *
     * @param integer $desactive
     *
     * @return TimputDir_i
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

    /**
     * Set imputation
     *
     * @param \Ediligence\EdiligenceBundle\Entity\Timputations_i $imputation
     *
     * @return TimputDir_i
     */
    public function setImputation(\Ediligence\EdiligenceBundle\Entity\Timputations_i $imputation)
    {
        $this->imputation = $imputation;

        return $this;
    }

    /**
     * Get imputation
     *
     * @return \Ediligence\EdiligenceBundle\Entity\Timputations_i
     */
    public function getImputation()
    {
        return $this->imputation;
    }

    /**
     * Set matriculeimpute
     *
     * @param \Agent\AgentBundle\Entity\Agent $matriculeimpute
     *
     * @return TimputDir_i
     */
    public function setMatriculeimpute(\Agent\AgentBundle\Entity\Agent $matriculeimpute = null)
    {
        $this->matriculeimpute = $matriculeimpute;

        return $this;
    }

    /**
     * Get matriculeimpute
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getMatriculeimpute()
    {
        return $this->matriculeimpute;
    }
}
