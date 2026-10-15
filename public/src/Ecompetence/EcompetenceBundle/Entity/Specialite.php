<?php

namespace Ecompetence\EcompetenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Specialite
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ecompetence\EcompetenceBundle\Entity\SpecialiteRepository")
 */
class Specialite
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
     * @ORM\Column(name="libspecialite", type="string", length=255)
     */
    private $libspecialite;

    public function __toString() {
        return $this->getLibspecialite();
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
     * Set libspecialite
     *
     * @param string $libspecialite
     *
     * @return Specialite
     */
    public function setLibspecialite($libspecialite)
    {
        $this->libspecialite = $libspecialite;

        return $this;
    }

    /**
     * Get libspecialite
     *
     * @return string
     */
    public function getLibspecialite()
    {
        return $this->libspecialite;
    }
}

