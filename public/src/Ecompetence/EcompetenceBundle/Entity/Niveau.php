<?php

namespace Ecompetence\EcompetenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Niveau
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ecompetence\EcompetenceBundle\Repository\NiveauRepository")
 */
class Niveau
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
     * @ORM\Column(name="LibNiveau", type="string", length=50)
     */
    private $libNiveau;
   
    public function __toString() {
        return $this->getLibNiveau();
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
     * Set libNiveau
     *
     * @param string $libNiveau
     *
     * @return Niveau
     */
    public function setLibNiveau($libNiveau)
    {
        $this->libNiveau = $libNiveau;

        return $this;
    }

    /**
     * Get libNiveau
     *
     * @return string
     */
    public function getLibNiveau()
    {
        return $this->libNiveau;
    }
}
