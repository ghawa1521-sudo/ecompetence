<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fonctionalite
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Repository\FonctionaliteRepository")
 */
class Fonctionalite {

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
     * @var Rubriques|null
     *
     * @ORM\OneToMany(targetEntity="Rubriques", mappedBy="fonctionalite",cascade={"persist"})
     * @ORM\JoinColumn( nullable=true)
     */
    private $rubriques;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=255)
     */
    private $categorie;

    function __toString() {
        return $this->getLibelle();
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->rubriques = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Fonctionalite
     */
    public function setLibelle($libelle) {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle() {
        return $this->libelle;
    }

    /**
     * Add rubrique
     *
     * @param \Agent\AgentBundle\Entity\Rubriques $rubrique
     *
     * @return Fonctionalite
     */
    public function addRubrique(\Agent\AgentBundle\Entity\Rubriques $rubrique) {
        $this->rubriques[] = $rubrique;

        return $this;
    }

    /**
     * Remove rubrique
     *
     * @param \Agent\AgentBundle\Entity\Rubriques $rubrique
     */
    public function removeRubrique(\Agent\AgentBundle\Entity\Rubriques $rubrique) {
        $this->rubriques->removeElement($rubrique);
    }

    /**
     * Get rubriques
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRubriques() {
        return $this->rubriques;
    }


    /**
     * Set categorie
     *
     * @param string $categorie
     *
     * @return Fonctionalite
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }
}
