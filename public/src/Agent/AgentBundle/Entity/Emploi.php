<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Emploi
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Repository\EmploiRepository")
 */
class Emploi
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
     * @ORM\Column(name="libEmpl", type="string", length=255)
     */
    private $libEmpl;

    /**
     * @ORM\ManyToOne(targetEntity="Grade")
     * @ORM\JoinColumn(name="id_grade", referencedColumnName="id")
     */
    protected $Grade;


    public function __toString()
    {
        return $this->getLibEmpl();
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
     * Set libEmpl
     *
     * @param string $libEmpl
     *
     * @return Emploi
     */
    public function setLibEmpl($libEmpl)
    {
        $this->libEmpl = $libEmpl;

        return $this;
    }

    /**
     * Get libEmpl
     *
     * @return string
     */
    public function getLibEmpl()
    {
        return $this->libEmpl;
    }

    /**
     * Set grade
     *
     * @param \Agent\AgentBundle\Entity\Grade $grade
     *
     * @return Emploi
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
