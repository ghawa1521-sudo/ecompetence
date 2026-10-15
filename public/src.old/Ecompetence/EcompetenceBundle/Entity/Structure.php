<?php

namespace Ecompetence\EcompetenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Structure
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ecompetence\EcompetenceBundle\Repository\StructureRepository")
 */
class Structure
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
     * @ORM\Column(name="LibStructure", type="string", length=125)
     */
    private $libStructure;

    /**
     * @ORM\ManyToOne(targetEntity="Secteur")
     * @ORM\JoinColumn(name="secteur_id", referencedColumnName="id", nullable=true)
     */
    private $secteur; 
    
    public function __toString() {
        return $this->getLibStructure();
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
     * Set libStructure
     *
     * @param string $libStructure
     *
     * @return Structure
     */
    public function setLibStructure($libStructure)
    {
        $this->libStructure = $libStructure;

        return $this;
    }

    /**
     * Get libStructure
     *
     * @return string
     */
    public function getLibStructure()
    {
        return $this->libStructure;
    }

    /**
     * Set secteur
     *
     * @param \Ecompetence\EcompetenceBundle\Entity\Secteur $secteur
     *
     * @return Structure
     */
    public function setSecteur(\Ecompetence\EcompetenceBundle\Entity\Secteur $secteur = null)
    {
        $this->secteur = $secteur;

        return $this;
    }

    /**
     * Get secteur
     *
     * @return \Ecompetence\EcompetenceBundle\Entity\Secteur
     */
    public function getSecteur()
    {
        return $this->secteur;
    }
}
