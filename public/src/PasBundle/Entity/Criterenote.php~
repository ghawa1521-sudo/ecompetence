<?php

namespace PasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Criterenote
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PasBundle\Repository\CriterenoteRepository")
 */
class Criterenote
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
     * @ORM\Column(name="plage", type="string", length=255)
     */
    private $plage;


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
     * Set plage
     *
     * @param string $plage
     *
     * @return Criterenote
     */
    public function setPlage($plage)
    {
        $this->plage = $plage;

        return $this;
    }

    /**
     * Get plage
     *
     * @return string
     */
    public function getPlage()
    {
        return $this->plage;
    }
}
