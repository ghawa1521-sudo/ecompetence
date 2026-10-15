<?php

namespace Ediligence\EdiligenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ttypecourrier
 *
 * @ORM\Table(name="ttypecourrier")
 * @ORM\Entity
 */
class Ttypecourrier
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
     * @ORM\Column(name="LibCourrier", type="string", length=30, nullable=false)
     */
    private $libcourrier;

    
    public function __toString()
    {
        return $this->getlibcourrier();
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
     * Set libcourrier
     *
     * @param string $libcourrier
     *
     * @return Ttypecourrier
     */
    public function setLibcourrier($libcourrier)
    {
        $this->libcourrier = $libcourrier;

        return $this;
    }

    /**
     * Get libcourrier
     *
     * @return string
     */
    public function getLibcourrier()
    {
        return $this->libcourrier;
    }
}
