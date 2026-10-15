<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PeriodeConges
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Repository\PeriodeCongesRepository")
 */
class PeriodeConges {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="duree", type="integer")
     */
    private $duree;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\ManyToOne(targetEntity="TypeConges",  cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $typeConges;

    public function __toString() {

        //return 'test: '.$this->getLibelle();
        return $this->getDuree() . ' ' . $this->getLibelle();
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
     * Set duree
     *
     * @param integer $duree
     *
     * @return PeriodeConges
     */
    public function setDuree($duree) {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get duree
     *
     * @return integer
     */
    public function getDuree() {
        return $this->duree;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return PeriodeConges
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
     * Set typeConges
     *
     * @param \Agent\AgentBundle\Entity\TypeConges $typeConges
     *
     * @return PeriodeConges
     */
    public function setTypeConges(\Agent\AgentBundle\Entity\TypeConges $typeConges = null) {
        $this->typeConges = $typeConges;

        return $this;
    }

    /**
     * Get typeConges
     *
     * @return \Agent\AgentBundle\Entity\TypeConges
     */
    public function getTypeConges() {
        return $this->typeConges;
    }

}
