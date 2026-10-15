<?php

namespace Annuaire\AnnuaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contact
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Annuaire\AnnuaireBundle\Entity\ContactRepository")
 */
class Contact
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
     * @ORM\Column(name="Fixe", type="string", length=30)
     */
    private $fixe;

    /**
     * @var string
     *
     * @ORM\Column(name="Cellulaire", type="string", length=30)
     */
    private $cellulaire;
    
    /**
     * @var Date
     *
     * 
     * @ORM\Column(name="datecreation", type="date")
     *
     */ 
    private $datecreation;

      /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent",  cascade={"persist"})
     * @ORM\JoinColumn(name="proprietaire", referencedColumnName="id")
     */
    private $propritaire;  

    

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
     * Set fixe
     *
     * @param string $fixe
     *
     * @return Contact
     */
    public function setFixe($fixe)
    {
        $this->fixe = $fixe;

        return $this;
    }

    /**
     * Get fixe
     *
     * @return string
     */
    public function getFixe()
    {
        return $this->fixe;
    }

    /**
     * Set cellulaire
     *
     * @param string $cellulaire
     *
     * @return Contact
     */
    public function setCellulaire($cellulaire)
    {
        $this->cellulaire = $cellulaire;

        return $this;
    }

    /**
     * Get cellulaire
     *
     * @return string
     */
    public function getCellulaire()
    {
        return $this->cellulaire;
    }

    /**
     * Set datecreation
     *
     * @param \DateTime $datecreation
     *
     * @return Contact
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
     * Set propritaire
     *
     * @param \Agent\AgentBundle\Entity\Agent $propritaire
     *
     * @return Contact
     */
    public function setPropritaire(\Agent\AgentBundle\Entity\Agent $propritaire = null)
    {
        $this->propritaire = $propritaire;

        return $this;
    }

    /**
     * Get propritaire
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getPropritaire()
    {
        return $this->propritaire;
    }
}
