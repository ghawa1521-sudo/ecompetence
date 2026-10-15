<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Promotion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Repository\PromotionRepository")
 */
class Promotion
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
     * @ORM\Column(name="numActePromo", type="string", length=30)
     */
    private $numActePromo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEffetPromo", type="date")
     */
    private $dateEffetPromo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateSignaPromo", type="date")
     */
    private $dateSignaPromo;


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
     * Set numActePromo
     *
     * @param string $numActePromo
     *
     * @return Promotion
     */
    public function setNumActePromo($numActePromo)
    {
        $this->numActePromo = $numActePromo;

        return $this;
    }

    /**
     * Get numActePromo
     *
     * @return string
     */
    public function getNumActePromo()
    {
        return $this->numActePromo;
    }

    /**
     * Set dateEffetPromo
     *
     * @param \DateTime $dateEffetPromo
     *
     * @return Promotion
     */
    public function setDateEffetPromo($dateEffetPromo)
    {
        $this->dateEffetPromo = $dateEffetPromo;

        return $this;
    }

    /**
     * Get dateEffetPromo
     *
     * @return \DateTime
     */
    public function getDateEffetPromo()
    {
        return $this->dateEffetPromo;
    }

    /**
     * Set dateSignaPromo
     *
     * @param \DateTime $dateSignaPromo
     *
     * @return Promotion
     */
    public function setDateSignaPromo($dateSignaPromo)
    {
        $this->dateSignaPromo = $dateSignaPromo;

        return $this;
    }

    /**
     * Get dateSignaPromo
     *
     * @return \DateTime
     */
    public function getDateSignaPromo()
    {
        return $this->dateSignaPromo;
    }
}
