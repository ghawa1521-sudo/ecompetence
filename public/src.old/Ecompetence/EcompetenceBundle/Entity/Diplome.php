<?php

namespace Ecompetence\EcompetenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Diplome
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ecompetence\EcompetenceBundle\Repository\DiplomeRepository")
 */
class Diplome
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
     * @ORM\Column(name="LibDiplome", type="string", length=255)
     */
    private $libDiplome;
    
      /**
     * @ORM\ManyToOne(targetEntity="Niveau")
     * @ORM\JoinColumn(name="niveau_id", referencedColumnName="id", nullable=true)
     */
    private $niveau; 
   
    public function __toString() {
        return $this->getLibDiplome();
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
     * Set libDiplome
     *
     * @param string $libDiplome
     *
     * @return Diplome
     */
    public function setLibDiplome($libDiplome)
    {
        $this->libDiplome = $libDiplome;

        return $this;
    }

    /**
     * Get libDiplome
     *
     * @return string
     */
    public function getLibDiplome()
    {
        return $this->libDiplome;
    }

    /**
     * Set niveau
     *
     * @param \Ecompetence\EcompetenceBundle\Entity\Niveau $niveau
     *
     * @return Diplome
     */
    public function setNiveau(\Ecompetence\EcompetenceBundle\Entity\Niveau $niveau = null)
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * Get niveau
     *
     * @return \Ecompetence\EcompetenceBundle\Entity\Niveau
     */
    public function getNiveau()
    {
        return $this->niveau;
    }
}
