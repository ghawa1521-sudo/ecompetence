<?php

namespace Ediligence\EdiligenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tnaturecourrier
 *
 * @ORM\Table(name="tnaturecourrier")
 * @ORM\Entity
 */
class Tnaturecourrier
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
     * @ORM\Column(name="libNatCour", type="string", length=50, nullable=false)
     */
    private $libnatcour;

   



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
     * Set libnatcour
     *
     * @param string $libnatcour
     *
     * @return Tnaturecourrier
     */
    public function setLibnatcour($libnatcour)
    {
        $this->libnatcour = $libnatcour;

        return $this;
    }

    /**
     * Get libnatcour
     *
     * @return string
     */
    public function getLibnatcour()
    {
        return $this->libnatcour;
    }
}
