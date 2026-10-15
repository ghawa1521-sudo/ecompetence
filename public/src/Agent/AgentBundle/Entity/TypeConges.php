<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeConges
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Repository\TypeCongesRepository")
 */
class TypeConges
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
     * @var integer
     *
     * @ORM\Column(name="jours", type="integer")
     */
    private $jours;

    /**
     * @var boolean
     *
     * @ORM\Column(name="etat", type="boolean")
     */
    private $etat;

    /**
     * @var integer
     *
     * @ORM\Column(name="sexe", type="integer",nullable=true)
     */
    private $Sexe = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="niveau", type="integer",nullable=true)
     */
    private $niveau;

    /**
     * @var integer
     *
     * @ORM\Column(name="minimum", type="integer",nullable=true)
     */
    private $minimum = 0;

    public function __toString()
    {

        //return 'test: '.$this->getLibelle();
        return $this->getLibelle() . ': ' . $this->getJours() . ' Jour(s)';
    }

    public function getRealLibelle($nbre = 0)
    {
        $value = $this->getLibelle();
        if ($nbre / $this->getJours() < 1 && $this->getId() == 1) {
            $value = "partiel";
        } elseif ($this->getId() == 3) {
            $value = "de paternité";
        } elseif ($this->getId() == 5) {
            $value = "de quatorze (14) semaines de congé de maternité";
        } elseif ($this->getId() == 6) { //Maladie Courte durée
            $value = "de maladie";
        }

        return $value;
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
     * @return TypeConges
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
     * Set jours
     *
     * @param integer $jours
     *
     * @return TypeConges
     */
    public function setJours($jours)
    {
        $this->jours = $jours;

        return $this;
    }

    /**
     * Get jours
     *
     * @return integer
     */
    public function getJours()
    {
        return $this->jours;
    }

    /**
     * Set etat
     *
     * @param boolean $etat
     *
     * @return TypeConges
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return boolean
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set sexe
     *
     * @param integer $sexe
     *
     * @return TypeConges
     */
    public function setSexe($sexe)
    {
        $this->Sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return integer
     */
    public function getSexe()
    {
        return $this->Sexe;
    }

    /**
     * Set niveau
     *
     * @param integer $niveau
     *
     * @return TypeConges
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * Get niveau
     *
     * @return integer
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * Set minimum
     *
     * @param integer $minimum
     *
     * @return TypeConges
     */
    public function setMinimum($minimum)
    {
        $this->minimum = $minimum;

        return $this;
    }

    /**
     * Get minimum
     *
     * @return integer
     */
    public function getMinimum()
    {
        return $this->minimum;
    }
}
