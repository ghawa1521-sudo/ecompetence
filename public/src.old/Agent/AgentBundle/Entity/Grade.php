<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Grade
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Repository\GradeRepository")
 */
class Grade
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
     * @ORM\Column(name="libGrade", type="string", length=4)
     */
    private $libGrade;

    public function __toString()
    {
        return $this->getLibGrade();
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
     * Set libGrade
     *
     * @param string $libGrade
     *
     * @return Grade
     */
    public function setLibGrade($libGrade)
    {
        $this->libGrade = $libGrade;

        return $this;
    }

    /**
     * Get libGrade
     *
     * @return string
     */
    public function getLibGrade()
    {
        return $this->libGrade;
    }
}
