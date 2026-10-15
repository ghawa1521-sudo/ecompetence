<?php

namespace Ecompetence\EcompetenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Secteur
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Secteur
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
     * @ORM\Column(name="LibSecteur", type="string", length=10)
     */
    private $libSecteur;

    public function __toString() {
        return $this->getLibSecteur();
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
     * Set libSecteur
     *
     * @param string $libSecteur
     *
     * @return Secteur
     */
    public function setLibSecteur($libSecteur)
    {
        $this->libSecteur = $libSecteur;

        return $this;
    }

    /**
     * Get libSecteur
     *
     * @return string
     */
    public function getLibSecteur()
    {
        return $this->libSecteur;
    }
}

