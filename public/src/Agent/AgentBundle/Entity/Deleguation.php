<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Deleguation
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Repository\DeleguationRepository")
 */
class Deleguation {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Rubriques|null
     *
     * @ORM\ManyToOne(targetEntity="Rubriques",cascade={"persist"})
     * @ORM\JoinColumn( nullable=true)
     */
    private $rubriques;

    /**
     * @var Agent|null
     *
     * @ORM\ManyToOne(targetEntity="Agent",cascade={"persist"})
     * @ORM\JoinColumn( nullable=true)
     */
    private $agent;

    /**
     * @var Agent|null
     *
     * @ORM\ManyToOne(targetEntity="Agent",cascade={"persist"})
     * @ORM\JoinColumn( nullable=true)
     */
    private $responsable;

    /**
     * @var Deleguer|null
     *
     * @ORM\ManyToOne(targetEntity="Deleguer", inversedBy="deleguation",cascade={"persist"})
     * @ORM\JoinColumn( nullable=false)
     */
    private $deleguer;

    /**
     * @var Direction|null
     *
     * @ORM\ManyToMany(targetEntity="Direction",cascade={"persist"})
     * @ORM\JoinColumn( nullable=true)
     */
    private $services;

    /**
     * @var Fonctionalite|null
     *
     * @ORM\ManyToOne(targetEntity="Fonctionalite", cascade={"persist"})
     * @ORM\JoinColumn( nullable=true)
     */
    private $fonctionalite;

    /**
     * @var Agent|null
     *
     * @ORM\ManyToOne(targetEntity="Agent",cascade={"persist"})
     * @ORM\JoinColumn( nullable=true)
     */
    private $deleguataire;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecreation", type="datetime", columnDefinition="timestamp default current_timestamp")
     */
    private $datecreation;

    public function __toString() {
        return "";
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
     * Set rubriques
     *
     * @param \Agent\AgentBundle\Entity\Rubriques $rubriques
     *
     * @return Deleguation
     */
    public function setRubriques(\Agent\AgentBundle\Entity\Rubriques $rubriques = null) {
        $this->rubriques = $rubriques;

        return $this;
    }

    /**
     * Get rubriques
     *
     * @return \Agent\AgentBundle\Entity\Rubriques
     */
    public function getRubriques() {
        return $this->rubriques;
    }

    /**
     * Set agent
     *
     * @param \Agent\AgentBundle\Entity\Agent $agent
     *
     * @return Deleguation
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
     * Set deleguer
     *
     * @param \Agent\AgentBundle\Entity\Deleguer $deleguer
     *
     * @return Deleguation
     */
    public function setDeleguer(\Agent\AgentBundle\Entity\Deleguer $deleguer) {
        $this->deleguer = $deleguer;

        return $this;
    }

    /**
     * Get deleguer
     *
     * @return \Agent\AgentBundle\Entity\Deleguer
     */
    public function getDeleguer() {
        return $this->deleguer;
    }

    /**
     * Set responsable
     *
     * @param \Agent\AgentBundle\Entity\Agent $responsable
     *
     * @return Deleguation
     */
    public function setResponsable(\Agent\AgentBundle\Entity\Agent $responsable = null) {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * Get responsable
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getResponsable() {
        return $this->responsable;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->services = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add service
     *
     * @param \Agent\AgentBundle\Entity\Direction $service
     *
     * @return Deleguation
     */
    public function addService(\Agent\AgentBundle\Entity\Direction $service) {
        $this->services[] = $service;

        return $this;
    }

    /**
     * Remove service
     *
     * @param \Agent\AgentBundle\Entity\Direction $service
     */
    public function removeService(\Agent\AgentBundle\Entity\Direction $service) {
        $this->services->removeElement($service);
    }

    /**
     * Get services
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getServices() {
        return $this->services;
    }

    /**
     * Get services
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArrayServices() {
        $tab = [];

        foreach ($this->services as $service) {
            # code...
            $tab[] = $service->getId();
        }
        return implode(",", $tab);
    }

    /**
     * Set fonctionalite
     *
     * @param \Agent\AgentBundle\Entity\Fonctionalite $fonctionalite
     *
     * @return Deleguer
     */
    public function setFonctionalite(\Agent\AgentBundle\Entity\Fonctionalite $fonctionalite = null) {
        $this->fonctionalite = $fonctionalite;

        return $this;
    }

    /**
     * Get fonctionalite
     *
     * @return \Agent\AgentBundle\Entity\Fonctionalite
     */
    public function getFonctionalite() {
        return $this->fonctionalite;
    }


    /**
     * Set datecreation
     *
     * @param \DateTime $datecreation
     *
     * @return Deleguation
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
     * Set deleguataire
     *
     * @param \Agent\AgentBundle\Entity\Agent $deleguataire
     *
     * @return Deleguation
     */
    public function setDeleguataire(\Agent\AgentBundle\Entity\Agent $deleguataire = null)
    {
        $this->deleguataire = $deleguataire;

        return $this;
    }

    /**
     * Get deleguataire
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getDeleguataire()
    {
        return $this->deleguataire;
    }
}
