<?php

namespace PasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notes
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PasBundle\Repository\NotesRepository")
 */
class Notes {

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
     * @ORM\Column(name="datecreation", type="datetime")
     */
    private $datecreation;


    /**
     * @var integer
     *
     * @ORM\Column(name="note", type="integer")
     */
    private $note;

    
    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent",  cascade={"persist"})
     * @ORM\JoinColumn(name="validateur", referencedColumnName="id")
     */
    private $validateur; 
    
    /**
     * @ORM\ManyToOne(targetEntity="PasBundle\Entity\Actions", inversedBy="notes", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $actions;

    
    public function __construct() {
        $this->datecreation = new \DateTime();
    }

    
    public function __toString() {
        return $this->getNote();
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
     * Set datecreation
     *
     * @param \DateTime $datecreation
     *
     * @return Notes
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
     * Set note
     *
     * @param integer $note
     *
     * @return Notes
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return integer
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set validateur
     *
     * @param \Agent\AgentBundle\Entity\Agent $validateur
     *
     * @return Notes
     */
    public function setValidateur(\Agent\AgentBundle\Entity\Agent $validateur = null)
    {
        $this->validateur = $validateur;

        return $this;
    }

    /**
     * Get validateur
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getValidateur()
    {
        return $this->validateur;
    }

    /**
     * Set actions
     *
     * @param \PasBundle\Entity\Actions $actions
     *
     * @return Notes
     */
    public function setActions(\PasBundle\Entity\Actions $actions = null)
    {
        $this->actions = $actions;

        return $this;
    }

    /**
     * Get actions
     *
     * @return \PasBundle\Entity\Actions
     */
    public function getActions()
    {
        return $this->actions;
    }
}
