<?php

namespace Ecompetence\EcompetenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Optiondiplome
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Optiondiplome
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
     * @ORM\Column(name="libOption", type="string", length=255)
     */
    private $libOption;
    
      /**
     * @ORM\ManyToOne(targetEntity="Specialite")
     * @ORM\JoinColumn(name="specialite_id", referencedColumnName="id", nullable=true)
     */
     private $specialite;
    
    public function __toString() {
        return $this->getLibOption();
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
     * Set libOption
     *
     * @param string $libOption
     *
     * @return Optiondiplome
     */
    public function setLibOption($libOption)
    {
        $this->libOption = $libOption;

        return $this;
    }

    /**
     * Get libOption
     *
     * @return string
     */
    public function getLibOption()
    {
        return $this->libOption;
    }

    /**
     * Set specialite
     *
     * @param \Ecompetence\EcompetenceBundle\Entity\Specialite $specialite
     *
     * @return Optiondiplome
     */
    public function setSpecialite(\Ecompetence\EcompetenceBundle\Entity\Specialite $specialite = null)
    {
        $this->specialite = $specialite;

        return $this;
    }

    /**
     * Get specialite
     *
     * @return \Ecompetence\EcompetenceBundle\Entity\Specialite
     */
    public function getSpecialite()
    {
        return $this->specialite;
    }
}
