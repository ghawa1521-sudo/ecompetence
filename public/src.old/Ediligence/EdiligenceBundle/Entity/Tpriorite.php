<?php

namespace Ediligence\EdiligenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tpriorite
 *
 * @ORM\Table(name="tpriorite")
 * @ORM\Entity
 */
class Tpriorite
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
     * @ORM\Column(name="libPriorite", type="string", length=30, nullable=false)
     */
    private $libpriorite;


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
     * Set libpriorite
     *
     * @param string $libpriorite
     *
     * @return Tpriorite
     */
    public function setLibpriorite($libpriorite)
    {
        $this->libpriorite = $libpriorite;

        return $this;
    }

    /**
     * Get libpriorite
     *
     * @return string
     */
    public function getLibpriorite()
    {
        return $this->libpriorite;
    }

    /**
     * Set nivpriorite
     *
     * @param string $nivpriorite
     *
     * @return Tpriorite
     */
    public function setNivpriorite($nivpriorite)
    {
        $this->nivpriorite = $nivpriorite;

        return $this;
    }

    /**
     * Get nivpriorite
     *
     * @return string
     */
    public function getNivpriorite()
    {
        return $this->nivpriorite;
    }
}
