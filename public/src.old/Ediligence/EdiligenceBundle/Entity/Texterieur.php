<?php

namespace Ediligence\EdiligenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Texterieur
 *
 * @ORM\Table(name="texterieur")
 * @ORM\Entity
 */
class Texterieur
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
     * @var string
     *
     * @ORM\Column(name="LIB", type="string", length=250, nullable=false)
     */
    private $lib;

    /**
     * @var integer
     *
     * @ORM\Column(name="ETAT", type="integer", nullable=false)
     */
    private $etat = '0';

   
 public function __toString()
    {
        return $this->getLib();
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
     * Set lib
     *
     * @param string $lib
     *
     * @return Texterieur
     */
    public function setLib($lib)
    {
        $this->lib = $lib;

        return $this;
    }

    /**
     * Get lib
     *
     * @return string
     */
    public function getLib()
    {
        return $this->lib;
    }

    /**
     * Set etat
     *
     * @param integer $etat
     *
     * @return Texterieur
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
