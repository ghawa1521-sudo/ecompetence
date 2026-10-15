<?php

namespace Ecompetence\EcompetenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Competence
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ecompetence\EcompetenceBundle\Repository\CompetenceRepository")
 */
class Competence
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
     * @ORM\Column(name="Libcompetence", type="string", length=100)
     */
    private $libcompetence;


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
     * Set libcompetence
     *
     * @param string $libcompetence
     *
     * @return Competence
     */
    public function setLibcompetence($libcompetence)
    {
        $this->libcompetence = $libcompetence;

        return $this;
    }

    /**
     * Get libcompetence
     *
     * @return string
     */
    public function getLibcompetence()
    {
        return $this->libcompetence;
    }
}

