<?php

namespace Ecompetence\EcompetenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Decoration
 *
 * @ORM\Table(name="decoration")
 * @ORM\Entity
 */
class Decoration
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
     * Libellé de la décoration
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
     * Année d'obtention
     * @ORM\Column(name="annee", type="integer")
     */
    private $annee;

    /**
     * Relation avec l'agent
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent")
     * @ORM\JoinColumn(name="agent_id", referencedColumnName="id", nullable=false)
     */
    private $agent;

    // Getters & Setters

    public function getId()
    {
        return $this->id;
    }

    public function getLibelle()
    {
        return $this->libelle;
    }

    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
        return $this;
    }

    public function getAnnee()
    {
        return $this->annee;
    }

    public function setAnnee($annee)
    {
        $this->annee = $annee;
        return $this;
    }

    public function getAgent()
    {
        return $this->agent;
    }

    public function setAgent($agent)
    {
        $this->agent = $agent;
        return $this;
    }
}