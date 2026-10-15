<?php

namespace BiblioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Droit
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="BiblioBundle\Repository\DroitRepository")
 */
class Droit {

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
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\OneToOne(targetEntity="Bouquin", inversedBy="droit")
     */
    private $bouquin;

    /**
     * @var string
     *
     * @ORM\Column(name="directions", type="text",nullable=true)
     */
    private $directions;

    /**
     * @var string
     *
     * @ORM\Column(name="responsables", type="text",nullable=true)
     */
    private $responsables;

    /**
     * @var string
     *
     * @ORM\Column(name="agents", type="text",nullable=true)
     */
    private $agents;

    public function __construct() {
        $this->date = new \DateTime();
    }

    public function hasDroit($direction) {
        return in_array($direction, $this->getDirections());
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Droit
     */
    public function setDate($date) {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Set directions
     *
     * @param string $directions
     *
     * @return Droit
     */
    public function setDirections($directions) {
        $this->directions = implode(',', $directions);
        return $this;
    }

    /**
     * Get directions
     *
     * @return string
     */
    public function getDirections() {
        $directions = explode(',', $this->directions);
        return $directions;
    }

    /**
     * Set responsables
     *
     * @param string $responsables
     *
     * @return Droit
     */
    public function setResponsables($responsables) {
        $this->responsables = implode(',', $responsables);
        return $this;
    }

    /**
     * Get responsables
     *
     * @return string
     */
    public function getResponsables() {
        $responsables = explode(',', $this->responsables);
        return $responsables;
    }

    /**
     * Set agents
     *
     * @param string $agents
     *
     * @return Droit
     */
    public function setAgents($agents) {
        $this->agents = implode(',', $agents);
        return $this;
    }

    /**
     * Get agents
     *
     * @return string
     */
    public function getAgents() {
        $agents = explode(',', $this->agents);
        return $agents;
    }

    /**
     * Set bouquin
     *
     * @param \BiblioBundle\Entity\Bouquin $bouquin
     *
     * @return Droit
     */
    public function setBouquin(\BiblioBundle\Entity\Bouquin $bouquin = null) {
        $this->bouquin = $bouquin;

        return $this;
    }

    /**
     * Get bouquin
     *
     * @return \BiblioBundle\Entity\Bouquin
     */
    public function getBouquin() {
        return $this->bouquin;
    }

}
