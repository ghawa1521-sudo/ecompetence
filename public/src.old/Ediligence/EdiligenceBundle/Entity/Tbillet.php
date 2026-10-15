<?php

namespace Ediligence\EdiligenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tbillet
 *
 * @ORM\Table(name="tbillet")
 * @ORM\Entity
 */
class Tbillet
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    
    
    /**
     * @var integer
     *
     * @ORM\Column(name="dateBillet", type="integer", nullable=false)
     */
    private $datebillet;

    /**
     * @var string
     *
     * @ORM\Column(name="txtBillet", type="text", length=65535, nullable=false)
     */
    private $txtbillet;

    /**
     * @var integer
     *
     * @ORM\Column(name="matricule", type="integer", nullable=false)
     */
    private $matricule;

    /**
     * @var integer
     *
     * @ORM\Column(name="pjBillet", type="integer", nullable=false)
     */
    private $pjbillet;

    /**
     * @var integer
     *
     * @ORM\Column(name="CodeCourrier", type="integer", nullable=false)
     */
    private $codecourrier;

    



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
     * Set datebillet
     *
     * @param integer $datebillet
     *
     * @return Tbillet
     */
    public function setDatebillet($datebillet)
    {
        $this->datebillet = $datebillet;

        return $this;
    }

    /**
     * Get datebillet
     *
     * @return integer
     */
    public function getDatebillet()
    {
        return $this->datebillet;
    }

    /**
     * Set txtbillet
     *
     * @param string $txtbillet
     *
     * @return Tbillet
     */
    public function setTxtbillet($txtbillet)
    {
        $this->txtbillet = $txtbillet;

        return $this;
    }

    /**
     * Get txtbillet
     *
     * @return string
     */
    public function getTxtbillet()
    {
        return $this->txtbillet;
    }

    /**
     * Set matricule
     *
     * @param integer $matricule
     *
     * @return Tbillet
     */
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;

        return $this;
    }

    /**
     * Get matricule
     *
     * @return integer
     */
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * Set pjbillet
     *
     * @param integer $pjbillet
     *
     * @return Tbillet
     */
    public function setPjbillet($pjbillet)
    {
        $this->pjbillet = $pjbillet;

        return $this;
    }

    /**
     * Get pjbillet
     *
     * @return integer
     */
    public function getPjbillet()
    {
        return $this->pjbillet;
    }

    /**
     * Set codecourrier
     *
     * @param integer $codecourrier
     *
     * @return Tbillet
     */
    public function setCodecourrier($codecourrier)
    {
        $this->codecourrier = $codecourrier;

        return $this;
    }

    /**
     * Get codecourrier
     *
     * @return integer
     */
    public function getCodecourrier()
    {
        return $this->codecourrier;
    }
}
