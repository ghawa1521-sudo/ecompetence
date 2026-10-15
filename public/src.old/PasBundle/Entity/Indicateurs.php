<?php

namespace PasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Indicateurs
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PasBundle\Repository\IndicateursRepository")
 */
class Indicateurs
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
     * @var string
     *
     * @ORM\Column(name="Libelleind", type="string", length=500)
     */
    private $libelleind;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecreation", type="datetime")
     */
    private $datecreation;


  
    
     public function __construct()
    {
        $this->datecreation = new \DateTime();
    }
    public function __toString() {
        return $this->getLibelleind();
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
     * Set libelleind
     *
     * @param string $libelleind
     *
     * @return Indicateurs
     */
    public function setLibelleind($libelleind)
    {
        $this->libelleind = $libelleind;

        return $this;
    }

    /**
     * Get libelleind
     *
     * @return string
     */
    public function getLibelleind()
    {
        return $this->libelleind;
    }

    /**
     * Set datecreation
     *
     * @param \DateTime $datecreation
     *
     * @return Indicateurs
     */
    public function setDatecreation($datecreation)
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    /**
     * Get datecreation
     *
     * @return \DateTime
     */
    public function getDatecreation()
    {
        return $this->datecreation;
    }
}
