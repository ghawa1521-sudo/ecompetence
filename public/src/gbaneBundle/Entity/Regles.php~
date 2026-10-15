<?php

namespace gbaneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Regles
 *
 * @ORM\Table(name="regles")
 * @ORM\Entity(repositoryClass="gbaneBundle\Repository\ReglesRepository")
 */
class Regles
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var integer
     *
     * @ORM\Column(name="anciennete_grade", type="integer", nullable=false)
     */
    private $ancienneteGrade = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="anciennete_dge", type="integer", nullable=false)
     */
    private $ancienneteDge = '0';
    
     /**
     * @var \gbaneBundle\Entity\FonctionAssimilees
     *
     * @ORM\ManyToOne(targetEntity="gbaneBundle\Entity\FonctionAssimilees")
     * @ORM\JoinColumn(name="fonction_assimilees", referencedColumnName="id")
     */
    private $FonctionAssimilees;
    
    /**
     * @var Agent\AgentBundle\Entity\Grade
     *
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Grade")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="grade", referencedColumnName="id")
     * })
     */
    private $grade;
    
    /**
     * @var \gbaneBundle\Entity\Pieces
     *
     * @ORM\ManyToOne(targetEntity="gbaneBundle\Entity\Pieces")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pieces", referencedColumnName="id")
     * })
     */
    private $pieces;
    
   

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
     * Set ancienneteGrade
     *
     * @param integer $ancienneteGrade
     *
     * @return Regles
     */
    public function setAncienneteGrade($ancienneteGrade)
    {
        $this->ancienneteGrade = $ancienneteGrade;

        return $this;
    }

    /**
     * Get ancienneteGrade
     *
     * @return integer
     */
    public function getAncienneteGrade()
    {
        return $this->ancienneteGrade;
    }

    /**
     * Set ancienneteDge
     *
     * @param integer $ancienneteDge
     *
     * @return Regles
     */
    public function setAncienneteDge($ancienneteDge)
    {
        $this->ancienneteDge = $ancienneteDge;

        return $this;
    }

    /**
     * Get ancienneteDge
     *
     * @return integer
     */
    public function getAncienneteDge()
    {
        return $this->ancienneteDge;
    }

    /**
     * Set fonctionAssimilees
     *
     * @param \gbaneBundle\Entity\FonctionAssimilees $fonctionAssimilees
     *
     * @return Regles
     */
    public function setFonctionAssimilees(\gbaneBundle\Entity\FonctionAssimilees $fonctionAssimilees = null)
    {
        $this->FonctionAssimilees = $fonctionAssimilees;

        return $this;
    }

    /**
     * Get fonctionAssimilees
     *
     * @return \gbaneBundle\Entity\FonctionAssimilees
     */
    public function getFonctionAssimilees()
    {
        return $this->FonctionAssimilees;
    }

    /**
     * Set grade
     *
     * @param \Agent\AgentBundle\Entity\Grade $grade
     *
     * @return Regles
     */
    public function setGrade(\Agent\AgentBundle\Entity\Grade $grade = null)
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * Get grade
     *
     * @return \Agent\AgentBundle\Entity\Grade
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * Set pieces
     *
     * @param \gbaneBundle\Entity\Pieces $pieces
     *
     * @return Regles
     */
    public function setPieces(\gbaneBundle\Entity\Pieces $pieces = null)
    {
        $this->pieces = $pieces;

        return $this;
    }

    /**
     * Get pieces
     *
     * @return \gbaneBundle\Entity\Pieces
     */
    public function getPieces()
    {
        return $this->pieces;
    }
}
