<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sexe
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Repository\SexeRepository")
 */
class Sexe {

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
     * @ORM\Column(name="libSexe", type="string", length=10)
     */
    private $libSexe;

    public function __toString() {
        return $this->getLibSexe();
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
     * Set libSexe
     *
     * @param string $libSexe
     *
     * @return Sexe
     */
    public function setLibSexe($libSexe) {
        $this->libSexe = $libSexe;

        return $this;
    }

    /**
     * Get libSexe
     *
     * @return string
     */
    public function getLibSexe() {
        return $this->libSexe;
    }

}
