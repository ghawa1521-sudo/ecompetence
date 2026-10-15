<?php

namespace Ediligence\EdiligenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TimputInstruction
 *
 * @ORM\Table(name="timput_instruction", indexes={@ORM\Index(name="Id_imput_dir", columns={"Id_imput_dir"}), @ORM\Index(name="Inst_imput", columns={"Inst_imput"})})
 * @ORM\Entity(repositoryClass="Ediligence\EdiligenceBundle\Repository\TimputInstructionRepository")
 */
class TimputInstruction {

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
     * @ORM\ManyToOne(targetEntity="TimputDir", cascade="persist")
     * @ORM\Column(name="Id_imput_dir", type="string", length=20, nullable=false)
     */
    private $idImputDir;

    /**
     * @ORM\ManyToOne(targetEntity="Timputations", cascade="persist")
     * @ORM\JoinColumn(nullable=false)
     */

    private $imputation;
   
    /**
     * @ORM\ManyToOne(targetEntity="Tinstruction", cascade="persist")
     * @ORM\JoinColumn(name="Inst_imput",nullable=false)
     */
    private $instImput;

   
    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent",  cascade={"persist"})
     * @ORM\JoinColumn(name="Imputmatricule", referencedColumnName="id", nullable=true)
     */
    private $imputMatricule;

    /**
     * @var integer
     *
     * @ORM\Column(name="Etat_inst", type="integer", nullable=false)
     */
    private $etatInst = '0';

    

    

   

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
     * Set idImputDir
     *
     * @param string $idImputDir
     *
     * @return TimputInstruction
     */
    public function setIdImputDir($idImputDir)
    {
        $this->idImputDir = $idImputDir;

        return $this;
    }

    /**
     * Get idImputDir
     *
     * @return string
     */
    public function getIdImputDir()
    {
        return $this->idImputDir;
    }

    /**
     * Set etatInst
     *
     * @param integer $etatInst
     *
     * @return TimputInstruction
     */
    public function setEtatInst($etatInst)
    {
        $this->etatInst = $etatInst;

        return $this;
    }

    /**
     * Get etatInst
     *
     * @return integer
     */
    public function getEtatInst()
    {
        return $this->etatInst;
    }

    /**
     * Set imputation
     *
     * @param \Ediligence\EdiligenceBundle\Entity\Timputations $imputation
     *
     * @return TimputInstruction
     */
    public function setImputation(\Ediligence\EdiligenceBundle\Entity\Timputations $imputation)
    {
        $this->imputation = $imputation;

        return $this;
    }

    /**
     * Get imputation
     *
     * @return \Ediligence\EdiligenceBundle\Entity\Timputations
     */
    public function getImputation()
    {
        return $this->imputation;
    }

    /**
     * Set instImput
     *
     * @param \Ediligence\EdiligenceBundle\Entity\Tinstruction $instImput
     *
     * @return TimputInstruction
     */
    public function setInstImput(\Ediligence\EdiligenceBundle\Entity\Tinstruction $instImput)
    {
        $this->instImput = $instImput;

        return $this;
    }

    /**
     * Get instImput
     *
     * @return \Ediligence\EdiligenceBundle\Entity\Tinstruction
     */
    public function getInstImput()
    {
        return $this->instImput;
    }

    /**
     * Set imputMatricule
     *
     * @param \Agent\AgentBundle\Entity\Agent $imputMatricule
     *
     * @return TimputInstruction
     */
    public function setImputMatricule(\Agent\AgentBundle\Entity\Agent $imputMatricule = null)
    {
        $this->imputMatricule = $imputMatricule;

        return $this;
    }

    /**
     * Get imputMatricule
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getImputMatricule()
    {
        return $this->imputMatricule;
    }
}
