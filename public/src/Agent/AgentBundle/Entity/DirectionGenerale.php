<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DirectionGenerale
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class DirectionGenerale
{
    /**
     * @var string
     * @ORM\Column(name="CODE_DG", type="string", length=10)
     * @ORM\Id
     */
    private $codeDg;


    /**
     * @var string
     *
     * @ORM\Column(name="DESIGNATION", type="string", length=255)
     */
    private $designation;
    
    /**
     * @var string
     *
     * @ORM\Column(name="abrv", type="string", length=255)
     */
    private $abrv;
    
     /**
     * @var integer
     *
     * @ORM\Column(name="etat", type="integer", nullable=true)
     */
    private $etat;
    

    public function __toString()
    {
        return $this->getDesignation();
    }


   

    /**
     * Set codeDg
     *
     * @param string $codeDg
     *
     * @return DirectionGenerale
     */
    public function setCodeDg($codeDg)
    {
        $this->codeDg = $codeDg;

        return $this;
    }

    /**
     * Get codeDg
     *
     * @return string
     */
    public function getCodeDg()
    {
        return $this->codeDg;
    }

    /**
     * Set designation
     *
     * @param string $designation
     *
     * @return DirectionGenerale
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
     * Set abrv
     *
     * @param string $abrv
     *
     * @return DirectionGenerale
     */
    public function setAbrv($abrv)
    {
        $this->abrv = $abrv;

        return $this;
    }

    /**
     * Get abrv
     *
     * @return string
     */
    public function getAbrv()
    {
        return $this->abrv;
    }
    
    /**
     * Set etat
     *
     * @param integer $etat
     *
     * @return integer
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return integer
     */
    public function getEtat()
    {
        return $this->etat;
    }

}
