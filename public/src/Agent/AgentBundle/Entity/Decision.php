<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Decision
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Entity\DecisionRepository")
 */
class Decision
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
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=255)
     */
    private $numero;

    /**
     * @ORM\ManyToOne(targetEntity="Exercice",  cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $exercice;

        /**
     * @ORM\ManyToOne(targetEntity="Direction",  cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $direction;

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
    
    public function __toString()
    {
        return $this->getNumero();
    }

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
     * @return Decision
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
     * Set numero
     *
     * @param string $numero
     *
     * @return Decision
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set exercice
     *
     * @param \Agent\AgentBundle\Entity\Exercice $exercice
     *
     * @return Decision
     */
    public function setExercice(\Agent\AgentBundle\Entity\Exercice $exercice = null)
    {
        $this->exercice = $exercice;

        return $this;
    }

    /**
     * Get exercice
     *
     * @return \Agent\AgentBundle\Entity\Exercice
     */
    public function getExercice()
    {
        return $this->exercice;
    }

    /**
     * Set direction
     *
     * @param \Agent\AgentBundle\Entity\Direction $direction
     *
     * @return Decision
     */
    public function setDirection(\Agent\AgentBundle\Entity\Direction $direction = null)
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * Get direction
     *
     * @return \Agent\AgentBundle\Entity\Direction
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * Set pj
     *
     * @param \Agent\AgentBundle\Entity\Pj $pj
     *
     * @return Decision
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
     * @return Decision
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
     * @return Decision
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
