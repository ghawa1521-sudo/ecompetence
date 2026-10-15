<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lieu_Naissance
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Repository\Lieu_NaissanceRepository")
 */
class Lieu_Naissance
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
     * @ORM\Column(name="lieuNaiss", type="string", length=255)
     */
    private $lieuNaiss;


 


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
     * Set lieuNaiss
     *
     * @param string $lieuNaiss
     *
     * @return Lieu_Naissance
     */
    public function setLieuNaiss($lieuNaiss)
    {
        $this->lieuNaiss = $lieuNaiss;

        return $this;
    }

    /**
     * Get lieuNaiss
     *
     * @return string
     */
    public function getLieuNaiss()
    {
        return $this->lieuNaiss;
    }


    public function __toString()
    {
        return $this->getLieuNaiss();
    }
}
