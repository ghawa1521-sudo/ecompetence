<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tracing
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Entity\TracingRepository")
 */
class Tracing
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
     * @ORM\Column(name="libelleAction", type="string", length=1000)
     */
    private $libelleAction;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecreation", type="datetime")
     *
     *
     */
    private $dateCreation;

    /**
     * @ORM\ManyToOne(targetEntity="Agent")
     * @ORM\JoinColumn(name="matricule", referencedColumnName="id")
     */
    private $matricule;

    /**
     * @var string
     *
     * @ORM\Column(name="route", type="string", length=20)
     */
    private $route;

    /**
     * @var string
     *
     * @ORM\Column(name="entite", type="string", length=20)
     */
    private $entite;

    /**
     * @var string
     *
     * @ORM\Column(name="entityId", type="string", length=10)
     */
    private $entityId;

    /**
     * @var string
     *
     * @ORM\Column(name="systemeExploitation", type="string", length=255)
     */
    private $systemeExploitation;

    /**
     * @var string
     *
     * @ORM\Column(name="addresseIp", type="string", length=30)
     */
    private $addresseIp;
    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="integer")
     */
    private $level;

    public function __construct()
    {
        $this->dateCreation = new \DateTime();
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
     * Set libelleAction
     *
     * @param string $libelleAction
     *
     * @return Tracing
     */
    public function setLibelleAction($libelleAction)
    {
        $this->libelleAction = $libelleAction;

        return $this;
    }

    /**
     * Get libelleAction
     *
     * @return string
     */
    public function getLibelleAction()
    {
        return $this->libelleAction;
    }

    /**
     * Set dateCreation
     *
     * @param string $dateCreation
     *
     * @return Tracing
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return string
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set matricule
     *
     * @param string $matricule
     *
     * @return Tracing
     */
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;

        return $this;
    }

    /**
     * Get matricule
     *
     * @return string
     */
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * Set route
     *
     * @param string $route
     *
     * @return Tracing
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set entity
     *
     * @param string $entity
     *
     * @return Tracing
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get entity
     *
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Set entityId
     *
     * @param string $entityId
     *
     * @return Tracing
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;

        return $this;
    }

    /**
     * Get entityId
     *
     * @return string
     */
    public function getEntityId()
    {
        return $this->entityId;
    }

    /**
     * Set systemeExploitation
     *
     * @param string $systemeExploitation
     *
     * @return Tracing
     */
    public function setSystemeExploitation($systemeExploitation)
    {
        $this->systemeExploitation = $systemeExploitation;

        return $this;
    }

    /**
     * Get systemeExploitation
     *
     * @return string
     */
    public function getSystemeExploitation()
    {
        return $this->systemeExploitation;
    }

    /**
     * Set addresseIp
     *
     * @param string $addresseIp
     *
     * @return Tracing
     */
    public function setAddresseIp($addresseIp)
    {
        $this->addresseIp = $addresseIp;

        return $this;
    }

    /**
     * Get addresseIp
     *
     * @return string
     */
    public function getAddresseIp()
    {
        return $this->addresseIp;
    }

    /**
     * Set entite
     *
     * @param string $entite
     *
     * @return Tracing
     */
    public function setEntite($entite)
    {
        $this->entite = $entite;

        return $this;
    }

    /**
     * Get entite
     *
     * @return string
     */
    public function getEntite()
    {
        return $this->entite;
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return Tracing
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }
}
