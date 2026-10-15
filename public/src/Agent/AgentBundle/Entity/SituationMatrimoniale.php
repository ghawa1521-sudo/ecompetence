<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SituationMatrimoniale
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Repository\SituationMatrimonialeRepository")
 */
class SituationMatrimoniale
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
     * @ORM\Column(name="libSituation", type="string", length=30)
     */
    private $libSituation;


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
     * Set libSituation
     *
     * @param string $libSituation
     *
     * @return SituationMatrimoniale
     */
    public function setLibSituation($libSituation)
    {
        $this->libSituation = $libSituation;

        return $this;
    }

    /**
     * Get libSituation
     *
     * @return string
     */
    public function getLibSituation()
    {
        return $this->libSituation;
    }
    
    public function __toString() {
        return $this->getLibSituation();
    }
}
