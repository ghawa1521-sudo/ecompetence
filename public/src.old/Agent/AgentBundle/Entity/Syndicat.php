<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Syndicat
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Repository\SyndicatRepository")
 */
class Syndicat
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
     * @ORM\Column(name="libSynd", type="string", length=255)
     */
    private $libSynd;

    public function __toString()
    {
        return $this->getLibSynd();
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
     * Set libSynd
     *
     * @param string $libSynd
     *
     * @return Syndicat
     */
    public function setLibSynd($libSynd)
    {
        $this->libSynd = $libSynd;

        return $this;
    }

    /**
     * Get libSynd
     *
     * @return string
     */
    public function getLibSynd()
    {
        return $this->libSynd;
    }
}
