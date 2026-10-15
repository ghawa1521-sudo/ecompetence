<?php

namespace PasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Objectifs
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PasBundle\Repository\ObjectifsRepository")
 */
class Objectifs {

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
     * @ORM\Column(name="libelleobj", type="string", length=500)
     */
    private $libelleobj;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecreation", type="datetime")
     */
    private $datecreation;

    /**
     * @ORM\ManyToOne(targetEntity="PasBundle\Entity\Axes", inversedBy="objectifs", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $axes;

    /**
     * @ORM\OneToMany(targetEntity="Actions",mappedBy="objectifs", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $actions;

    public function __construct() {
        $this->datecreation = new \DateTime();
    }

    public function __toString() {
        return $this->getLibelleobj();
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
     * Set libelleobj
     *
     * @param string $libelleobj
     *
     * @return Objectifs
     */
    public function setLibelleobj($libelleobj)
    {
        $this->libelleobj = $libelleobj;

        return $this;
    }

    /**
     * Get libelleobj
     *
     * @return string
     */
    public function getLibelleobj()
    {
        return $this->libelleobj;
    }

    /**
     * Set datecreation
     *
     * @param \DateTime $datecreation
     *
     * @return Objectifs
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
     * Set axes
     *
     * @param \PasBundle\Entity\Axes $axes
     *
     * @return Objectifs
     */
    public function setAxes(\PasBundle\Entity\Axes $axes)
    {
        $this->axes = $axes;

        return $this;
    }

    /**
     * Get axes
     *
     * @return \PasBundle\Entity\Axes
     */
    public function getAxes()
    {
        return $this->axes;
    }

    /**
     * Add action
     *
     * @param \PasBundle\Entity\Actions $action
     *
     * @return Objectifs
     */
    public function addAction(\PasBundle\Entity\Actions $action)
    {
        $this->actions[] = $action;

        return $this;
    }

    /**
     * Remove action
     *
     * @param \PasBundle\Entity\Actions $action
     */
    public function removeAction(\PasBundle\Entity\Actions $action)
    {
        $this->actions->removeElement($action);
    }

    /**
     * Get actions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActions()
    {
        return $this->actions;
    }
}
