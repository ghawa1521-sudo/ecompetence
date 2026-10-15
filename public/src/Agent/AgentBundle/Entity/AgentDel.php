<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AgentDel
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Repository\AgentDelRepository")
 */
class AgentDel
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
     * @ORM\Column(name="nature", type="string", length=255)
     */
    private $nature;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="objet", type="object")
     */
    private $objet;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecreation", type="datetime")
     */
    private $datecreation;

    /**
     * @var string
     *
     * @ORM\Column(name="acteur", type="string", length=255)
     */
    private $acteur;


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
     * Set nature
     *
     * @param string $nature
     *
     * @return AgentDel
     */
    public function setNature($nature)
    {
        $this->nature = $nature;

        return $this;
    }

    /**
     * Get nature
     *
     * @return string
     */
    public function getNature()
    {
        return $this->nature;
    }

    /**
     * Set objet
     *
     * @param \stdClass $objet
     *
     * @return AgentDel
     */
    public function setObjet($objet)
    {
        $this->objet = $objet;

        return $this;
    }

    /**
     * Get objet
     *
     * @return \stdClass
     */
    public function getObjet()
    {
        return $this->objet;
    }

    /**
     * Set datecreation
     *
     * @param \DateTime $datecreation
     *
     * @return AgentDel
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
     * Set acteur
     *
     * @param string $acteur
     *
     * @return AgentDel
     */
    public function setActeur($acteur)
    {
        $this->acteur = $acteur;

        return $this;
    }

    /**
     * Get acteur
     *
     * @return string
     */
    public function getActeur()
    {
        return $this->acteur;
    }
}
