<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ServiceDirection
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ServiceDirection
{
    /**
     * @var string
     *
     * @ORM\Column(name="CODE_SC", type="string", length=10)
     *
     * @ORM\Id
     */
    private $code_sc;


    /**
     * @var string
     *
     * @ORM\Column(name="DESIGNATION", type="string", length=255)
     */
    private $designation;

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\SousDirection",  cascade={"persist"})
     * @ORM\JoinColumn(name="CODE_SD", referencedColumnName="CODE_SD", nullable=true)
     */
    private $codeSousDir;

    /**
     * @var string
     *
     * @ORM\Column(name="abrv", type="string", length=255)
     */
    private $abrv;
    
    public function __toString()
    {
        return $this->getDesignation();
    }

    /**
     * Get abrv
     *
     * @return string
     */
    public function getAbrv()
    {
       if(empty($this->abrv)){
         return $this->designation;   
       }else{
         return $this->abrv;  
       }
        
    }
    
    /**
     * Set codeSc
     *
     * @param string $codeSc
     *
     * @return ServiceDirection
     */
    public function setCodeSc($codeSc)
    {
        $this->code_sc = $codeSc;

        return $this;
    }

    /**
     * Get codeSc
     *
     * @return string
     */
    public function getCodeSc()
    {
        return $this->code_sc;
    }

    /**
     * Set designation
     *
     * @param string $designation
     *
     * @return ServiceDirection
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * Get designation
     *
     * @return string
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * Set codeSousDir
     *
     * @param \Agent\AgentBundle\Entity\SousDirection $codeSousDir
     *
     * @return ServiceDirection
     */
    public function setCodeSousDir(\Agent\AgentBundle\Entity\SousDirection $codeSousDir = null)
    {
        $this->codeSousDir = $codeSousDir;

        return $this;
    }

    /**
     * Get codeSousDir
     *
     * @return \Agent\AgentBundle\Entity\SousDirection
     */
    public function getCodeSousDir()
    {
        return $this->codeSousDir;
    }

    /**
     * Set abrv
     *
     * @param string $abrv
     *
     * @return ServiceDirection
     */
    public function setAbrv($abrv)
    {
        $this->abrv = $abrv;

        return $this;
    }

    
}
