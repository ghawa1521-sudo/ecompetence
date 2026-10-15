<?php

namespace BiblioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bouquin
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="BiblioBundle\Repository\BouquinRepository")
 */
class Bouquin
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
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="details", type="text")
     */
    private $details;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecreation", type="datetime")
     */
    private $datecreation;
    
     /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Direction")
     */
    private $direction;
   
    
    /**
    * @ORM\ManyToOne(targetEntity="Users\UsersBundle\Entity\Users")
    */
    private $createur;
    
    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Pj", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $pj;
    
    /**
    * @ORM\OneToOne(targetEntity="Droit", mappedBy="bouquin")
    */
    private $droit;
    
    
      /**
     * @ORM\ManyToOne(targetEntity="Categorie")
     */
    private $categorie;
    
    public function __construct() {
        $this->datecreation= new \DateTime();
    }
    
    public function __toString() {
        return $this->getLibelle();
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
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Bouquin
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set details
     *
     * @param string $details
     *
     * @return Bouquin
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set datecreation
     *
     * @param \DateTime $datecreation
     *
     * @return Bouquin
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
     * Set direction
     *
     * @param \Agent\AgentBundle\Entity\Direction $direction
     *
     * @return Bouquin
     */
    public function setDirection(\Agent\AgentBundle\Entity\Direction $direction = null)
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * Get direction
     *
     * @return \Agent\AgentBundle\Entity\Direction
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * Set createur
     *
     * @param \Users\UsersBundle\Entity\Users $createur
     *
     * @return Bouquin
     */
    public function setCreateur(\Users\UsersBundle\Entity\Users $createur = null)
    {
        $this->createur = $createur;

        return $this;
    }

    /**
     * Get createur
     *
     * @return \Users\UsersBundle\Entity\Users
     */
    public function getCreateur()
    {
        return $this->createur;
    }

    /**
     * Set pj
     *
     * @param \Agent\AgentBundle\Entity\Pj $pj
     *
     * @return Bouquin
     */
    public function setPj(\Agent\AgentBundle\Entity\Pj $pj)
    {
        $this->pj = $pj;

        return $this;
    }

    /**
     * Get pj
     *
     * @return \Agent\AgentBundle\Entity\Pj
     */
    public function getPj()
    {
        return $this->pj;
    }

    /**
     * Set droit
     *
     * @param \BiblioBundle\Entity\Droit $droit
     *
     * @return Bouquin
     */
    public function setDroit(\BiblioBundle\Entity\Droit $droit = null)
    {
        $this->droit = $droit;

        return $this;
    }

    /**
     * Get droit
     *
     * @return \BiblioBundle\Entity\Droit
     */
    public function getDroit()
    {
        return $this->droit;
    }

    /**
     * Set categorie
     *
     * @param \BiblioBundle\Entity\Categorie $categorie
     *
     * @return Bouquin
     */
    public function setCategorie(\BiblioBundle\Entity\Categorie $categorie = null)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \BiblioBundle\Entity\Categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }
}
