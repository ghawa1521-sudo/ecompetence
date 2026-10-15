<?php

namespace Ecompetence\EcompetenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cv_direction
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Cv_direction
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
     * @ORM\Column(name="libdirection", type="string", length=255)
     */
    private $libdirection;

    /**
     * @var string
     *
     * @ORM\Column(name="abrv", type="string", length=10)
     */
    private $abrv;
         /**
     * @ORM\ManyToOne(targetEntity="Cv_directiongle")
     * @ORM\JoinColumn(name="cv_direction_id", referencedColumnName="id", nullable=true)
     */
    private $cvdirectiongle;
    
     public function __toString() {
        return $this->getLibdirection();
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
     * Set libdirection
     *
     * @param string $libdirection
     *
     * @return Cv_direction
     */
    public function setLibdirection($libdirection)
    {
        $this->libdirection = $libdirection;

        return $this;
    }

    /**
     * Get libdirection
     *
     * @return string
     */
    public function getLibdirection()
    {
        return $this->libdirection;
    }

    /**
     * Set abrv
     *
     * @param string $abrv
     *
     * @return Cv_direction
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
     * Set cvdirectiongle
     *
     * @param \Ecompetence\EcompetenceBundle\Entity\Cv_directiongle $cvdirectiongle
     *
     * @return Cv_direction
     */
    public function setCvdirectiongle(\Ecompetence\EcompetenceBundle\Entity\Cv_directiongle $cvdirectiongle = null)
    {
        $this->cvdirectiongle = $cvdirectiongle;

        return $this;
    }

    /**
     * Get cvdirectiongle
     *
     * @return \Ecompetence\EcompetenceBundle\Entity\Cv_directiongle
     */
    public function getCvdirectiongle()
    {
        return $this->cvdirectiongle;
    }
}
