<?php

namespace Agent\AgentBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Numerisation
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Entity\NumerisationRepository")
 */
class Numerisation
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetimetz")
     * @Assert\LessThanOrEqual("today",message="Désolé, vous ne pouvez pas saisir une date du futur!")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="Pj", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $pj;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAutoAjoutEnreg", type="datetime", nullable=true)
     */
    private $dateAutoAjoutDec;

    /**
     * @ORM\ManyToOne(targetEntity="Agent")
     * @ORM\JoinColumn(name="matAjoutEnreg", referencedColumnName="id", nullable=true)
     */
    private $matAjoutDec;
    /**
     * Constructor
     */
   public function __construct() {
        
        $this->dateAutoAjoutDec = new \DateTime('now');
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Numerisation
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set pj
     *
     * @param \Agent\AgentBundle\Entity\Pj $pj
     *
     * @return Numerisation
     */
    public function setPj(\Agent\AgentBundle\Entity\Pj $pj = null)
    {
        $this->pj = $pj;

        return $this;
    }

    /**
     * Get pj
     *
     * @return \Agent\AgentBundle\Entity\Pj
     */
    public function getPj()
    {
        return $this->pj;
    }

    /**
     * Set dateAutoAjoutDec
     *
     * @param \DateTime $dateAutoAjoutDec
     *
     * @return Numerisation
     */
    public function setDateAutoAjoutDec($dateAutoAjoutDec)
    {
        $this->dateAutoAjoutDec = $dateAutoAjoutDec;

        return $this;
    }

    /**
     * Get dateAutoAjoutDec
     *
     * @return \DateTime
     */
    public function getDateAutoAjoutDec()
    {
        return $this->dateAutoAjoutDec;
    }

    /**
     * Set matAjoutDec
     *
     * @param \Agent\AgentBundle\Entity\Agent $matAjoutDec
     *
     * @return Numerisation
     */
    public function setMatAjoutDec(\Agent\AgentBundle\Entity\Agent $matAjoutDec = null)
    {
        $this->matAjoutDec = $matAjoutDec;

        return $this;
    }

    /**
     * Get matAjoutDec
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getMatAjoutDec()
    {
        return $this->matAjoutDec;
    }
}
