<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Indice
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Indice
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
     * @var integer
     *
     * @ORM\Column(name="numero", type="integer")
     */
    private $numero;

    /**
     * @ORM\ManyToOne(targetEntity="Echelon")
     * @ORM\JoinColumn(name="id_Echelon", referencedColumnName="id")
     */
    protected $Echelon;



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
     * Set numero
     *
     * @param integer $numero
     *
     * @return Indice
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set echelon
     *
     * @param \Agent\AgentBundle\Entity\Echelon $echelon
     *
     * @return Indice
     */
    public function setEchelon(\Agent\AgentBundle\Entity\Echelon $echelon = null)
    {
        $this->Echelon = $echelon;

        return $this;
    }

    /**
     * Get echelon
     *
     * @return \Agent\AgentBundle\Entity\Echelon
     */
    public function getEchelon()
    {
        return $this->Echelon;
    }
}
