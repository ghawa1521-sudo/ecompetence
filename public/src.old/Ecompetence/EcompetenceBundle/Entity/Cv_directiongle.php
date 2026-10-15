<?php

namespace Ecompetence\EcompetenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cv_directiongle
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ecompetence\EcompetenceBundle\Repository\Cv_directiongleRepository")
 * @ORM\Entity
 */
class Cv_directiongle
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
     * @ORM\Column(name="libdirectiongle", type="string", length=255)
     */
    private $libdirectiongle;

    /**
     * @var string
     *
     * @ORM\Column(name="abrv", type="string", length=10)
     */
    private $abrv;
        /**
     * @ORM\ManyToOne(targetEntity="Structure")
     * @ORM\JoinColumn(name="structure_id", referencedColumnName="id", nullable=true)
     */
    private $structure;
    
    public function __toString() {
        return $this->getLibdirectiongle();
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
     * Set libdirectiongle
     *
     * @param string $libdirectiongle
     *
     * @return Cv_directiongle
     */
    public function setLibdirectiongle($libdirectiongle)
    {
        $this->libdirectiongle = $libdirectiongle;

        return $this;
    }

    /**
     * Get libdirectiongle
     *
     * @return string
     */
    public function getLibdirectiongle()
    {
        return $this->libdirectiongle;
    }

    /**
     * Set abrv
     *
     * @param string $abrv
     *
     * @return Cv_directiongle
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
     * Set structure
     *
     * @param \Ecompetence\EcompetenceBundle\Entity\Structure $structure
     *
     * @return Cv_directiongle
     */
    public function setStructure(\Ecompetence\EcompetenceBundle\Entity\Structure $structure = null)
    {
        $this->structure = $structure;

        return $this;
    }

    /**
     * Get structure
     *
     * @return \Ecompetence\EcompetenceBundle\Entity\Structure
     */
    public function getStructure()
    {
        return $this->structure;
    }
}
