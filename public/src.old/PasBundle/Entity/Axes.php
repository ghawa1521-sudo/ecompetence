<?php

namespace PasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Axes
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PasBundle\Repository\AxesRepository")
 */
class Axes
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
     * @var \DateTime
     *
     * @ORM\Column(name="datecreation", type="datetime")
     */
    private $datecreation;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Exercice", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    
    private $exercice;
    
    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Direction", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    
    private $direction;
    
   /**
     * @ORM\ManyToOne(targetEntity="PasBundle\Entity\Pas", inversedBy="axes", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    
    private $pas;
    
    /**
     * @ORM\OneToMany(targetEntity="Objectifs",mappedBy="axes", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    
    private $objectifs;
    
    
    
     public function __construct()
    {
        $this->datecreation = new \DateTime();
    }
   

    public function __toString() {
        return $this->getLibelle();
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
     * Set datecreation
     *
     * @param \DateTime $datecreation
     *
     * @return Axes
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
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Axes
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set exercice
     *
     * @param \Agent\AgentBundle\Entity\Exercice $exercice
     *
     * @return Axes
     */
    public function setExercice(\Agent\AgentBundle\Entity\Exercice $exercice = null)
    {
        $this->exercice = $exercice;

        return $this;
    }

    /**
     * Get exercice
     *
     * @return \Agent\AgentBundle\Entity\Exercice
     */
    public function getExercice()
    {
        return $this->exercice;
    }

    /**
     * Set direction
     *
     * @param \Agent\AgentBundle\Entity\Direction $direction
     *
     * @return Axes
     */
    public function setDirection(\Agent\AgentBundle\Entity\Direction $direction = null)
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * Get direction
     *
     * @return \Agent\AgentBundle\Entity\Direction
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * Set pas
     *
     * @param \PasBundle\Entity\Pas $pas
     *
     * @return Axes
     */
    public function setPas(\PasBundle\Entity\Pas $pas = null)
    {
        $this->pas = $pas;

        return $this;
    }

    /**
     * Get pas
     *
     * @return \PasBundle\Entity\Pas
     */
    public function getPas()
    {
        return $this->pas;
    }

    /**
     * Add objectif
     *
     * @param \PasBundle\Entity\Objectifs $objectif
     *
     * @return Axes
     */
    public function addObjectif(\PasBundle\Entity\Objectifs $objectif)
    {
        $this->objectifs[] = $objectif;

        return $this;
    }

    /**
     * Remove objectif
     *
     * @param \PasBundle\Entity\Objectifs $objectif
     */
    public function removeObjectif(\PasBundle\Entity\Objectifs $objectif)
    {
        $this->objectifs->removeElement($objectif);
    }

    /**
     * Get objectifs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getObjectifs()
    {
        return $this->objectifs;
    }

}
