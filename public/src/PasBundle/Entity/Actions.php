<?php

namespace PasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Actions
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PasBundle\Repository\ActionsRepository")
 */
class Actions
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
     * @ORM\Column(name="libelleaction", type="string", length=500)
     */
    private $libelleaction;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecreation", type="datetime")
     */
    private $datecreation;

/**
     * @ORM\ManyToOne(targetEntity="PasBundle\Entity\Objectifs", inversedBy="actions", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    
    private $objectifs;
    
     /**
     * @var string
     *
     * @ORM\Column(name="calendar", type="string", length=500,nullable=true)
     */
    private $calendar;
    
     /**
     * @ORM\ManyToOne(targetEntity="PasBundle\Entity\Indicateurs", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    
    private $indicateurs;
    
    /**
     * @ORM\ManyToOne(targetEntity="PasBundle\Entity\Budget", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    
    private $budget;
    /**
     * @ORM\ManyToOne(targetEntity="PasBundle\Entity\Partenaires", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    
    private $partenaires;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="PasBundle\Entity\Resultats", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    
    private $resultats;
    /**
     * @ORM\ManyToOne(targetEntity="PasBundle\Entity\Sources", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    
    private $sources;
    
    /**
     * @ORM\Column(name="criterenote", type="integer",nullable=true)
     * @ORM\JoinColumn(nullable=true)
     */
    private $criterenote;
    
   /**
     * @ORM\OneToMany(targetEntity="Notes",mappedBy="actions", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    
    private $notes;
    
    /**
     * @ORM\
     * ManyToOne(targetEntity="Agent\AgentBundle\Entity\Pj", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $piecejointe;
    
    
    public function __construct()
    {
        $this->datecreation = new \DateTime();
    }


    public function __toString() {
        return $this->getLibelleaction();
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
     * Set libelleaction
     *
     * @param string $libelleaction
     *
     * @return Actions
     */
    public function setLibelleaction($libelleaction)
    {
        $this->libelleaction = $libelleaction;

        return $this;
    }

    /**
     * Get libelleaction
     *
     * @return string
     */
    public function getLibelleaction()
    {
        return $this->libelleaction;
    }

    /**
     * Set datecreation
     *
     * @param \DateTime $datecreation
     *
     * @return Actions
     */
    public function setDatecreation($datecreation)
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    /**
     * Get datecreation
     *
     * @return \DateTime
     */
    public function getDatecreation()
    {
        return $this->datecreation;
    }

    /**
     * Set calendar
     *
     * @param string $calendar
     *
     * @return Actions
     */
    public function setCalendar($calendar)
    {
        $this->calendar = $calendar;

        return $this;
    }

    /**
     * Get calendar
     *
     * @return string
     */
    public function getCalendar()
    {
        return $this->calendar;
    }

    /**
     * Set criterenote
     *
     * @param integer $criterenote
     *
     * @return Actions
     */
    public function setCriterenote($criterenote)
    {
        $this->criterenote = $criterenote;

        return $this;
    }

    /**
     * Get criterenote
     *
     * @return integer
     */
    public function getCriterenote()
    {
        return $this->criterenote;
    }

    /**
     * Set objectifs
     *
     * @param \PasBundle\Entity\Objectifs $objectifs
     *
     * @return Actions
     */
    public function setObjectifs(\PasBundle\Entity\Objectifs $objectifs)
    {
        $this->objectifs = $objectifs;

        return $this;
    }

    /**
     * Get objectifs
     *
     * @return \PasBundle\Entity\Objectifs
     */
    public function getObjectifs()
    {
        return $this->objectifs;
    }

    /**
     * Set indicateurs
     *
     * @param \PasBundle\Entity\Indicateurs $indicateurs
     *
     * @return Actions
     */
    public function setIndicateurs(\PasBundle\Entity\Indicateurs $indicateurs = null)
    {
        $this->indicateurs = $indicateurs;

        return $this;
    }

    /**
     * Get indicateurs
     *
     * @return \PasBundle\Entity\Indicateurs
     */
    public function getIndicateurs()
    {
        return $this->indicateurs;
    }

    /**
     * Set budget
     *
     * @param \PasBundle\Entity\Budget $budget
     *
     * @return Actions
     */
    public function setBudget(\PasBundle\Entity\Budget $budget = null)
    {
        $this->budget = $budget;

        return $this;
    }

    /**
     * Get budget
     *
     * @return \PasBundle\Entity\Budget
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * Set partenaires
     *
     * @param \PasBundle\Entity\Partenaires $partenaires
     *
     * @return Actions
     */
    public function setPartenaires(\PasBundle\Entity\Partenaires $partenaires = null)
    {
        $this->partenaires = $partenaires;

        return $this;
    }

    /**
     * Get partenaires
     *
     * @return \PasBundle\Entity\Partenaires
     */
    public function getPartenaires()
    {
        return $this->partenaires;
    }

    /**
     * Set resultats
     *
     * @param \PasBundle\Entity\Resultats $resultats
     *
     * @return Actions
     */
    public function setResultats(\PasBundle\Entity\Resultats $resultats = null)
    {
        $this->resultats = $resultats;

        return $this;
    }

    /**
     * Get resultats
     *
     * @return \PasBundle\Entity\Resultats
     */
    public function getResultats()
    {
        return $this->resultats;
    }

    /**
     * Set sources
     *
     * @param \PasBundle\Entity\Sources $sources
     *
     * @return Actions
     */
    public function setSources(\PasBundle\Entity\Sources $sources = null)
    {
        $this->sources = $sources;

        return $this;
    }

    /**
     * Get sources
     *
     * @return \PasBundle\Entity\Sources
     */
    public function getSources()
    {
        return $this->sources;
    }

    /**
     * Add note
     *
     * @param \PasBundle\Entity\Notes $note
     *
     * @return Actions
     */
    public function addNote(\PasBundle\Entity\Notes $note)
    {
        $this->notes[] = $note;

        return $this;
    }

    /**
     * Remove note
     *
     * @param \PasBundle\Entity\Notes $note
     */
    public function removeNote(\PasBundle\Entity\Notes $note)
    {
        $this->notes->removeElement($note);
    }

    /**
     * Get notes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set piecejointe
     *
     * @param \Agent\AgentBundle\Entity\Pj $piecejointe
     *
     * @return Actions
     */
    public function setPiecejointe(\Agent\AgentBundle\Entity\Pj $piecejointe = null)
    {
        $this->piecejointe = $piecejointe;

        return $this;
    }

    /**
     * Get piecejointe
     *
     * @return \Agent\AgentBundle\Entity\Pj
     */
    public function getPiecejointe()
    {
        return $this->piecejointe;
    }
}
