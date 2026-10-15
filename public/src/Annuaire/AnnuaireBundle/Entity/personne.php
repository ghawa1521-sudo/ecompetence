<?php

namespace Annuaire\AnnuaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * personne
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Annuaire\AnnuaireBundle\Entity\personneRepository")
 */
class personne
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenoms", type="string", length=255)
     */
    private $prenoms;
    
    /**
     * @ORM\ManyToOne(targetEntity="Annuaire\AnnuaireBundle\Entity\Test",  cascade={"persist"})
     * @ORM\JoinColumn(name="pays", referencedColumnName="id")
     */
    private $pays;
    
    /**
     * @ORM\ManyToOne(targetEntity="Annuaire\AnnuaireBundle\Entity\ville",  cascade={"persist"})
     * @ORM\JoinColumn(name="ville", referencedColumnName="id")
     */
    private $ville;

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
     * Set nom
     *
     * @param string $nom
     *
     * @return personne
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenoms
     *
     * @param string $prenoms
     *
     * @return personne
     */
    public function setPrenoms($prenoms)
    {
        $this->prenoms = $prenoms;

        return $this;
    }

    /**
     * Get prenoms
     *
     * @return string
     */
    public function getPrenoms()
    {
        return $this->prenoms;
    }

    /**
     * Set pays
     *
     * @param \Annuaire\AnnuaireBundle\Entity\Test $pays
     *
     * @return personne
     */
    public function setPays(\Annuaire\AnnuaireBundle\Entity\Test $pays = null)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return \Annuaire\AnnuaireBundle\Entity\Test
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set ville
     *
     * @param \Annuaire\AnnuaireBundle\Entity\ville $ville
     *
     * @return personne
     */
    public function setVille(\Annuaire\AnnuaireBundle\Entity\ville $ville = null)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return \Annuaire\AnnuaireBundle\Entity\ville
     */
    public function getVille()
    {
        return $this->ville;
    }
}
