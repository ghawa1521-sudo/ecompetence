<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fonction
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Repository\FonctionRepository")
 */
class Fonction
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
     * @ORM\Column(name="libFonc", type="string", length=255)
     */
    private $libFonc;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="priorite", type="integer")
     */
    private $priorite;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="sup", type="integer")
     */
    private $sup;
    
    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\RoleAgent", cascade="persist")
     * @ORM\JoinColumn(nullable=true)
     */
    private $typeCompte; 
    
    public function __toString()
    {
        return $this->getLibFonc();
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
     * Set libFonc
     *
     * @param string $libFonc
     *
     * @return Fonction
     */
    public function setLibFonc($libFonc)
    {
        $this->libFonc = $libFonc;

        return $this;
    }

    /**
     * Get libFonc
     *
     * @return string
     */
    public function getLibFonc()
    {
        return $this->libFonc;
    }

    /**
     * Set priorite
     *
     * @param integer $priorite
     *
     * @return Fonction
     */
    public function setPriorite($priorite)
    {
        $this->priorite = $priorite;

        return $this;
    }

    /**
     * Get priorite
     *
     * @return integer
     */
    public function getPriorite()
    {
        return $this->priorite;
    }

    /**
     * Set sup
     *
     * @param integer $sup
     *
     * @return Fonction
     */
    public function setSup($sup)
    {
        $this->sup = $sup;

        return $this;
    }

    /**
     * Get sup
     *
     * @return integer
     */
    public function getSup()
    {
        return $this->sup;
    }

    /**
     * Set typeCompte
     *
     * @param \Agent\AgentBundle\Entity\RoleAgent $typeCompte
     *
     * @return Fonction
     */
    public function setTypeCompte(\Agent\AgentBundle\Entity\RoleAgent $typeCompte = null)
    {
        $this->typeCompte = $typeCompte;

        return $this;
    }

    /**
     * Get typeCompte
     *
     * @return \Agent\AgentBundle\Entity\RoleAgent
     */
    public function getTypeCompte()
    {
        return $this->typeCompte;
    }
}
