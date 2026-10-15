<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Type
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Repository\TypeRepository")
 */
class Type
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
     * @ORM\Column(name="libType", type="string", length=255)
     */
    private $libType;

    public function __toString()
    {
        return $this->getLibType();
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
     * Set libType
     *
     * @param string $libType
     *
     * @return Type
     */
    public function setLibType($libType)
    {
        $this->libType = $libType;

        return $this;
    }

    /**
     * Get libType
     *
     * @return string
     */
    public function getLibType()
    {
        return $this->libType;
    }
}
