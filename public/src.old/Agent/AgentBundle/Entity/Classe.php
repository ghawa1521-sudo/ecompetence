<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Repository\ClasseRepository")
 */
class Classe
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
     * @ORM\Column(name="libClas", type="string", length=255)
     */
    private $libClas;

    /**
     * @ORM\ManyToOne(targetEntity="Grade")
     * @ORM\JoinColumn(name="id_grade", referencedColumnName="id")
     */
    protected $Grade;

    public function __toString()
    {
        return $this->getLibClas();
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
     * Set libClas
     *
     * @param string $libClas
     *
     * @return Classe
     */
    public function setLibClas($libClas)
    {
        $this->libClas = $libClas;

        return $this;
    }

    /**
     * Get libClas
     *
     * @return string
     */
    public function getLibClas()
    {
        return $this->libClas;
    }

    /**
     * Set grade
     *
     * @param \Agent\AgentBundle\Entity\Grade $grade
     *
     * @return Classe
     */
    public function setGrade(\Agent\AgentBundle\Entity\Grade $grade = null)
    {
        $this->Grade = $grade;

        return $this;
    }

    /**
     * Get grade
     *
     * @return \Agent\AgentBundle\Entity\Grade
     */
    public function getGrade()
    {
        return $this->Grade;
    }
}
