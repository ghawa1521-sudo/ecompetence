<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Avis
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Repository\AvisRepository")
 */
class Avis {

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
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent",  cascade={"persist"})
     * @ORM\JoinColumn(name="agent", referencedColumnName="id")
     */
    private $agent;

    /**
     * @ORM\OneToOne(targetEntity="Agent\AgentBundle\Entity\Conges", inversedBy="avis", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $conge;

    /**
     * @ORM\OneToOne(targetEntity="Demandes\DemandesBundle\Entity\Demande", inversedBy="avis", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $demande;

    /**
     * @var integer
     *
     * @ORM\Column(name="etat", type="integer", nullable=true)
     */
    private $etat;

    public function __construct() {

        $this->date = new \DateTime();
    }

    public function getLibAvis() {
        if ($this->etat == 1) {
            return "<strong>Approbation</strong>";
        } elseif ($this->etat == 2) {
            return "<strong>Refus</strong>";
        } else {
            return "<strong>Initi&#233; saaf</strong>";
        }
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
     * @return Avis
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
     * Set etat
     *
     * @param integer $etat
     *
     * @return Avis
     */
    public function setEtat($etat) {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return integer
     */
    public function getEtat() {
        return $this->etat;
    }

    /**
     * Set agent
     *
     * @param \Agent\AgentBundle\Entity\Agent $agent
     *
     * @return Avis
     */
    public function setAgent(\Agent\AgentBundle\Entity\Agent $agent = null) {
        $this->agent = $agent;

        return $this;
    }

    /**
     * Get agent
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getAgent() {
        return $this->agent;
    }

    /**
     * Set conge
     *
     * @param \Agent\AgentBundle\Entity\Conges $conge
     *
     * @return Avis
     */
    public function setConge(\Agent\AgentBundle\Entity\Conges $conge = null) {
        $this->conge = $conge;

        return $this;
    }

    /**
     * Get conge
     *
     * @return \Agent\AgentBundle\Entity\Conges
     */
    public function getConge() {
        return $this->conge;
    }

    /**
     * Set demande
     *
     * @param \Demandes\DemandesBundle\Entity\Demande $demande
     *
     * @return Avis
     */
    public function setDemande(\Demandes\DemandesBundle\Entity\Demande $demande = null) {
        $this->demande = $demande;

        return $this;
    }

    /**
     * Get demande
     *
     * @return \Demandes\DemandesBundle\Entity\Demande
     */
    public function getDemande() {
        return $this->demande;
    }

}
