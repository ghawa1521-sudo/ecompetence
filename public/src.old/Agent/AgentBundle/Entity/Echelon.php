<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Echelon
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Repository\EchelonRepository")
 */
class Echelon
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
     * @ORM\Column(name="libEchelon", type="string", length=255)
     */
    private $libEchelon;

    /**
     * @ORM\ManyToOne(targetEntity="Classe")
     * @ORM\JoinColumn(name="id_classe", referencedColumnName="id")
     */
    protected $Classe;

    public function __toString()
    {
        return $this->getLibEchelon();
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
     * Set libEchelon
     *
     * @param string $libEchelon
     *
     * @return Echelon
     */
    public function setLibEchelon($libEchelon)
    {
        $this->libEchelon = $libEchelon;

        return $this;
    }

    /**
     * Get libEchelon
     *
     * @return string
     */
    public function getLibEchelon()
    {
        return $this->libEchelon;
    }

    /**
     * Set classe
     *
     * @param \Agent\AgentBundle\Entity\Classe $classe
     *
     * @return Echelon
     */
    public function setClasse(\Agent\AgentBundle\Entity\Classe $classe = null)
    {
        $this->Classe = $classe;

        return $this;
    }

    /**
     * Get classe
     *
     * @return \Agent\AgentBundle\Entity\Classe
     */
    public function getClasse()
    {
        return $this->Classe;
    }
}
