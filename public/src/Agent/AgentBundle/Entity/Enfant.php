<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Enfant
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Repository\EnfantRepository")
 */
class Enfant
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
     * @ORM\Column(name="nomEnf", type="string", length=30)
     */
    private $nomEnf;

    /**
     * @var string
     *
     * @ORM\Column(name="prenEnf", type="string", length=100)
     */
    private $prenEnf;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNaissEnf", type="date")
     */
    private $dateNaissEnf;

    /**
     * @var string
     *
     * @ORM\Column(name="lieuNaissEnf", type="string", length=255)
     */
    private $lieuNaissEnf;

    /**
     * @var boolean
     *
     * @ORM\Column(name="scolarise", type="boolean")
     */
    private $scolarise;


    /**
     * @ORM\ManyToOne(targetEntity="Agent")
     * @ORM\JoinColumn(name="agent_matricule", referencedColumnName="id")
     */
    protected $Agent;


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
     * Set nomEnf
     *
     * @param string $nomEnf
     *
     * @return Enfant
     */
    public function setNomEnf($nomEnf)
    {
        $this->nomEnf = $nomEnf;

        return $this;
    }

    /**
     * Get nomEnf
     *
     * @return string
     */
    public function getNomEnf()
    {
        return $this->nomEnf;
    }

    /**
     * Set prenEnf
     *
     * @param string $prenEnf
     *
     * @return Enfant
     */
    public function setPrenEnf($prenEnf)
    {
        $this->prenEnf = $prenEnf;

        return $this;
    }

    /**
     * Get prenEnf
     *
     * @return string
     */
    public function getPrenEnf()
    {
        return $this->prenEnf;
    }

    /**
     * Set dateNaissEnf
     *
     * @param \DateTime $dateNaissEnf
     *
     * @return Enfant
     */
    public function setDateNaissEnf($dateNaissEnf)
    {
        $this->dateNaissEnf = $dateNaissEnf;

        return $this;
    }

    /**
     * Get dateNaissEnf
     *
     * @return \DateTime
     */
    public function getDateNaissEnf()
    {
        return $this->dateNaissEnf;
    }

    /**
     * Set lieuNaissEnf
     *
     * @param string $lieuNaissEnf
     *
     * @return Enfant
     */
    public function setLieuNaissEnf($lieuNaissEnf)
    {
        $this->lieuNaissEnf = $lieuNaissEnf;

        return $this;
    }

    /**
     * Get lieuNaissEnf
     *
     * @return string
     */
    public function getLieuNaissEnf()
    {
        return $this->lieuNaissEnf;
    }

    /**
     * Set scolarise
     *
     * @param boolean $scolarise
     *
     * @return Enfant
     */
    public function setScolarise($scolarise)
    {
        $this->scolarise = $scolarise;

        return $this;
    }

    /**
     * Get scolarise
     *
     * @return boolean
     */
    public function getScolarise()
    {
        return $this->scolarise;
    }

    /**
     * Set agent
     *
     * @param \Agent\AgentBundle\Entity\Agent $agent
     *
     * @return Enfant
     */
    public function setAgent(\Agent\AgentBundle\Entity\Agent $agent = null)
    {
        $this->Agent = $agent;

        return $this;
    }

    /**
     * Get agent
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getAgent()
    {
        return $this->Agent;
    }
}
