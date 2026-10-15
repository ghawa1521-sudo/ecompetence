<?php

namespace Ecompetence\EcompetenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConnaissanceInformatique
 *
 * @ORM\Table(name="connaissance_informatique")
 * @ORM\Entity
 */
class ConnaissanceInformatique
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
     * Libellé de la compétence
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
     * Niveau de maîtrise (ex: Débutant, Intermédiaire, Avancé)
     * @ORM\Column(name="niveau", type="string", length=50)
     */
    private $niveau;

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

    public function getNiveau()
    {
        return $this->niveau;
    }

    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;
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