<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Imputation
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Repository\ImputationRepository")
 */
class Imputation
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
     * @ORM\Column(name="dateImputation", type="datetime")
     */
    private $dateImputation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateTraitement", type="datetime", nullable=true)
     */
    private $dateTraitement;

    /**
     * @var string
     *
     * @ORM\Column(name="objetImputation", type="string", length=255)
     */
    private $objetImputation;

    /**
     * @var integer
     *
     * @ORM\Column(name="objetId", type="integer")
     */
    private $objetId;


    /**
     * @var integer
     *
     * @ORM\Column(name="etat", type="integer")
     */
    private $etat=0;

    /**
     * @var integer
     *
     * @ORM\Column(name="etatTrt", type="integer")
     */
    private $etatTraitement=0;

    /**
     * @ORM\ManyToOne(targetEntity="Agent")
     * @ORM\JoinColumn(name="matImputateur", referencedColumnName="id")
     */
    private $matImputateur;

    /**
     * @ORM\ManyToOne(targetEntity="Agent")
     * @ORM\JoinColumn(name="matImputer", referencedColumnName="id")
     */
    private $matImputer;

    /**
     * @var string
     *
     * @ORM\Column(name="actions", type="string", length=255)
     */
    private $actions;


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
     * Set dateImputation
     *
     * @param \DateTime $dateImputation
     *
     * @return Imputation
     */
    public function setDateImputation($dateImputation)
    {
        $this->dateImputation = $dateImputation;

        return $this;
    }

    /**
     * Get dateImputation
     *
     * @return \DateTime
     */
    public function getDateImputation()
    {
        return $this->dateImputation;
    }

    /**
     * Set objetImputation
     *
     * @param string $objetImputation
     *
     * @return Imputation
     */
    public function setObjetImputation($objetImputation)
    {
        $this->objetImputation = $objetImputation;

        return $this;
    }

    /**
     * Get objetImputation
     *
     * @return string
     */
    public function getObjetImputation()
    {
        return $this->objetImputation;
    }

    /**
     * Set objetId
     *
     * @param integer $objetId
     *
     * @return Imputation
     */
    public function setObjetId($objetId)
    {
        $this->objetId = $objetId;

        return $this;
    }

    /**
     * Get objetId
     *
     * @return integer
     */
    public function getObjetId()
    {
        return $this->objetId;
    }

    /**
     * Set etat
     *
     * @param integer $etat
     *
     * @return Imputation
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return integer
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set dateTraitement
     *
     * @param \DateTime $dateTraitement
     *
     * @return Imputation
     */
    public function setDateTraitement($dateTraitement)
    {
        $this->dateTraitement = $dateTraitement;

        return $this;
    }

    /**
     * Get dateTraitement
     *
     * @return \DateTime
     */
    public function getDateTraitement()
    {
        return $this->dateTraitement;
    }

    /**
     * Set matImputateur
     *
     * @param \Agent\AgentBundle\Entity\Agent $matImputateur
     *
     * @return Imputation
     */
    public function setMatImputateur(\Agent\AgentBundle\Entity\Agent $matImputateur = null)
    {
        $this->matImputateur = $matImputateur;

        return $this;
    }

    /**
     * Get matImputateur
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getMatImputateur()
    {
        return $this->matImputateur;
    }

    /**
     * Set matImputer
     *
     * @param \Agent\AgentBundle\Entity\Agent $matImputer
     *
     * @return Imputation
     */
    public function setMatImputer(\Agent\AgentBundle\Entity\Agent $matImputer = null)
    {
        $this->matImputer = $matImputer;

        return $this;
    }

    /**
     * Get matImputer
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getMatImputer()
    {
        return $this->matImputer;
    }

    /**
     * Set actions
     *
     * @param string $actions
     *
     * @return Imputation
     */
    public function setActions($actions)
    {
        $this->actions = $actions;

        return $this;
    }

    /**
     * Get actions
     *
     * @return string
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * Set etatTraitement
     *
     * @param integer $etatTraitement
     *
     * @return Imputation
     */
    public function setEtatTraitement($etatTraitement)
    {
        $this->etatTraitement = $etatTraitement;

        return $this;
    }

    /**
     * Get etatTraitement
     *
     * @return integer
     */
    public function getEtatTraitement()
    {
        return $this->etatTraitement;
    }
}
