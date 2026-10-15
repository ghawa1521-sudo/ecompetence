<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SousDirection
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class SousDirection
{
    /**
     * @var string
     *
     * @ORM\Column(name="CODE_SD", type="string", length=10)
     *
     * @ORM\Id
     */
    private $code_sd;


    /**
     * @var string
     *
     * @ORM\Column(name="DESIGNATION", type="string", length=255)
     */
    private $designation;

    /**
     * @ORM\ManyToOne(targetEntity="Direction")
     * @ORM\JoinColumn(name="CODE_DC", referencedColumnName="id")
     */
    private $code_dc;
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
     * Set codeSd
     *
     * @param string $codeSd
     *
     * @return SousDirection
     */
    public function setCodeSd($codeSd)
    {
        $this->code_sd = $codeSd;

        return $this;
    }

    /**
     * Get codeSd
     *
     * @return string
     */
    public function getCodeSd()
    {
        return $this->code_sd;
    }

    /**
     * Set designation
     *
     * @param string $designation
     *
     * @return SousDirection
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
     * Set codeDc
     *
     * @param \Agent\AgentBundle\Entity\Direction $codeDc
     *
     * @return SousDirection
     */
    public function setCodeDc(\Agent\AgentBundle\Entity\Direction $codeDc = null)
    {
        $this->code_dc = $codeDc;

        return $this;
    }

    /**
     * Get codeDc
     *
     * @return \Agent\AgentBundle\Entity\Direction
     */
    public function getCodeDc()
    {
        return $this->code_dc;
    }

    /**
     * Set abrv
     *
     * @param string $abrv
     *
     * @return SousDirection
     */
    public function setAbrv($abrv)
    {
        $this->abrv = $abrv;

        return $this;
    }

    
}
