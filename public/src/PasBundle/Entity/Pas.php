<?php

namespace PasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pas
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PasBundle\Repository\PasRepository")
 */
class Pas
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
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Exercice", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    
    private $exercice;
    
    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Direction", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    
    private $direction;
    /**
     * @ORM\OneToMany(targetEntity="Axes",mappedBy="pas", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    
    private $axes;
    
    /**
     * @ORM\ManyToOne(targetEntity="PasBundle\Entity\Naturepas", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $naturepas;
    
    public function __construct()
    {
        $this->datecreation = new \DateTime();
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
     * @return Pas
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
     * Set exercice
     *
     * @param \Agent\AgentBundle\Entity\Exercice $exercice
     *
     * @return Pas
     */
    public function setExercice(\Agent\AgentBundle\Entity\Exercice $exercice)
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
     * @return Pas
     */
    public function setDirection(\Agent\AgentBundle\Entity\Direction $direction)
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
     * Add axe
     *
     * @param \PasBundle\Entity\Axes $axe
     *
     * @return Pas
     */
    public function addAxis(\PasBundle\Entity\Axes $axe)
    {
        $this->axes[] = $axe;

        return $this;
    }

    /**
     * Remove axe
     *
     * @param \PasBundle\Entity\Axes $axe
     */
    public function removeAxis(\PasBundle\Entity\Axes $axe)
    {
        $this->axes->removeElement($axe);
    }

    /**
     * Get axes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAxes()
    {
        return $this->axes;
    }

    /**
     * Set naturepas
     *
     * @param \PasBundle\Entity\Naturepas $naturepas
     *
     * @return Pas
     */
    public function setNaturepas(\PasBundle\Entity\Naturepas $naturepas = null)
    {
        $this->naturepas = $naturepas;

        return $this;
    }

    /**
     * Get naturepas
     *
     * @return \PasBundle\Entity\Naturepas
     */
    public function getNaturepas()
    {
        return $this->naturepas;
    }
    
}
