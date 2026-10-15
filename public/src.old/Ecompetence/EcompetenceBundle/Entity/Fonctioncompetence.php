<?php

namespace Ecompetence\EcompetenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fonctioncompetence
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ecompetence\EcompetenceBundle\Repository\FonctioncompetenceRepository")
 */
class Fonctioncompetence
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
     * @ORM\Column(name="LibFonct", type="string", length=100)
     */
    private $libFonct;


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
     * Set libFonct
     *
     * @param string $libFonct
     *
     * @return Fonctioncompetence
     */
    public function setLibFonct($libFonct)
    {
        $this->libFonct = $libFonct;

        return $this;
    }

    /**
     * Get libFonct
     *
     * @return string
     */
    public function getLibFonct()
    {
        return $this->libFonct;
    }
}

