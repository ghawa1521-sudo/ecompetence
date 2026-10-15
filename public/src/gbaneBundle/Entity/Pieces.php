<?php

namespace gbaneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pieces
 *
 * @ORM\Table(name="pieces")
 * @ORM\Entity(repositoryClass="gbaneBundle\Repository\PiecesRepository")
 */
class Pieces
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var string
     *
     * @ORM\Column(name="libelle_abr", type="string", length=100, nullable=false)
     */
    private $libelleAbr;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=500, nullable=false)
     */
    private $libelle;
    
     public function __toString() {
        return $this->getLibelleAbr();
    }
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set libelleAbr
     *
     * @param string $libelleAbr
     *
     * @return Pieces
     */
    public function setLibelleAbr($libelleAbr)
    {
        $this->libelleAbr = $libelleAbr;

        return $this;
    }

    /**
     * Get libelleAbr
     *
     * @return string
     */
    public function getLibelleAbr()
    {
        return $this->libelleAbr;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Pieces
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
}
