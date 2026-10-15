<?php

namespace Ediligence\EdiligenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tspref
 *
 * @ORM\Table(name="tspref", uniqueConstraints={@ORM\UniqueConstraint(name="Code_spref", columns={"CODE_SPREF"})})
 * @ORM\Entity
 */
class Tspref
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="CODE_SPREF", type="string", length=20, nullable=false)
     */
    private $codeSpref;

    /**
     * @var string
     *
     * @ORM\Column(name="LIB_SPREF", type="string", length=200, nullable=false)
     */
    private $libSpref;

    /**
     * @var integer
     *
     * @ORM\Column(name="ACTIF", type="integer", nullable=false)
     */
    private $actif = '0';

    



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
     * Set codeSpref
     *
     * @param string $codeSpref
     *
     * @return Tspref
     */
    public function setCodeSpref($codeSpref)
    {
        $this->codeSpref = $codeSpref;

        return $this;
    }

    /**
     * Get codeSpref
     *
     * @return string
     */
    public function getCodeSpref()
    {
        return $this->codeSpref;
    }

    /**
     * Set libSpref
     *
     * @param string $libSpref
     *
     * @return Tspref
     */
    public function setLibSpref($libSpref)
    {
        $this->libSpref = $libSpref;

        return $this;
    }

    /**
     * Get libSpref
     *
     * @return string
     */
    public function getLibSpref()
    {
        return $this->libSpref;
    }

    /**
     * Set actif
     *
     * @param integer $actif
     *
     * @return Tspref
     */
    public function setActif($actif)
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get actif
     *
     * @return integer
     */
    public function getActif()
    {
        return $this->actif;
    }
}
