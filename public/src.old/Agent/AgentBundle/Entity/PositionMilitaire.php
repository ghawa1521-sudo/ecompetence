<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PositionMilitaire
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Repository\PositionMilitaireRepository")
 */
class PositionMilitaire
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
     * @ORM\Column(name="libPosition", type="string", length=30)
     */
    private $libPosition;


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
     * Set libPosition
     *
     * @param string $libPosition
     *
     * @return PositionMilitaire
     */
    public function setLibPosition($libPosition)
    {
        $this->libPosition = $libPosition;

        return $this;
    }

    /**
     * Get libPosition
     *
     * @return string
     */
    public function getLibPosition()
    {
        return $this->libPosition;
    }
    
    public function __toString() {
        return $this->getLibPosition();
    }
}
