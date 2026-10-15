<?php

namespace Ecompetence\EcompetenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Atout
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Atout
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
     * @ORM\Column(name="libatout", type="string", length=255)
     */
    private $libatout;


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
     * Set libatout
     *
     * @param string $libatout
     *
     * @return Atout
     */
    public function setLibatout($libatout)
    {
        $this->libatout = $libatout;

        return $this;
    }

    /**
     * Get libatout
     *
     * @return string
     */
    public function getLibatout()
    {
        return $this->libatout;
    }
}
