<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Titre
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Repository\TitreRepository")
 */
class Titre {

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
     * @ORM\Column(name="libTitre", type="string", length=255)
     */
    private $libTitre;

    public function __toString() {
        return $this->getLibTitre();
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
     * Set libTitre
     *
     * @param string $libTitre
     *
     * @return Titre
     */
    public function setLibTitre($libTitre) {
        $this->libTitre = $libTitre;

        return $this;
    }

    /**
     * Get libTitre
     *
     * @return string
     */
    public function getLibTitre() {
        return $this->libTitre;
    }

}
