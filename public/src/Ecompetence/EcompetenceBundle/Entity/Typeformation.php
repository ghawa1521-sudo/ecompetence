<?php

namespace Ecompetence\EcompetenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeFormation
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ecompetence\EcompetenceBundle\Repository\TypeFormationRepository")
 */
class Typeformation
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
     * @ORM\Column(name="LibTypeFormation", type="string", length=255)
     */
    private $libTypeFormation;

 public function __toString() {
        return $this->getLibTypeFormation();
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
     * Set libTypeFormation
     *
     * @param string $libTypeFormation
     *
     * @return TypeFormation
     */
    public function setLibTypeFormation($libTypeFormation)
    {
        $this->libTypeFormation = $libTypeFormation;

        return $this;
    }

   

    /**
     * Get libTypeFormation
     *
     * @return string
     */
    public function getLibTypeFormation()
    {
        return $this->libTypeFormation;
    }
}
