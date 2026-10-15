<?php

namespace Ecompetence\EcompetenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;
/**
 * Agent_Langue
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ecompetence\EcompetenceBundle\Repository\Agent_LangueRepository")
 */
class Agent_Langue
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
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent")
     * @ORM\JoinColumn(name="agent_id", referencedColumnName="id", nullable=true)
     */
    private $agent; 
   
     /**
     * @ORM\ManyToOne(targetEntity="Langue")
     * @ORM\JoinColumn(name="langue_id", referencedColumnName="id", nullable=true)
     * @Assert\NotNull(message="Choissez la langue ")
     */
    private $langue; 

     /**
     * @var string
     *
     * @ORM\Column(name="lire", type="string", length=15)
     * @Assert\NotNull(message="Choissez le niveau en lecture")
     */
    private $lire;
     /**
     * @var string
     *
     * @ORM\Column(name="ecrire", type="string", length=15)
     * @Assert\NotNull(message="Choissez le niveau en écriture")
     */
    private $ecrire;
     /**
     * @var string
     *
     * @ORM\Column(name="parler", type="string", length=15)
     * @Assert\NotNull(message="Choissez le niveau en parole")
     */
    private $parler;
    // Dans l'entité Agent_Langue, ajoutez un champ typelangue de compétence
    
   /**
     * @var string
     *
     * @ORM\Column(name="type_langue", type="string", length=255, nullable=true)
     */
    private $TypeLangue;

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
     * Set lire
     *
     * @param string $lire
     *
     * @return Agent_Langue
     */
    public function setLire($lire)
    {
        $this->lire = $lire;

        return $this;
    }

    /**
     * Get lire
     *
     * @return string
     */
    public function getLire()
    {
        return $this->lire;
    }

    /**
     * Set ecrire
     *
     * @param string $ecrire
     *
     * @return Agent_Langue
     */
    public function setEcrire($ecrire)
    {
        $this->ecrire = $ecrire;

        return $this;
    }

    /**
     * Get ecrire
     *
     * @return string
     */
    public function getEcrire()
    {
        return $this->ecrire;
    }

    /**
     * Set parler
     *
     * @param string $parler
     *
     * @return Agent_Langue
     */
    public function setParler($parler)
    {
        $this->parler = $parler;

        return $this;
    }

    /**
     * Get parler
     *
     * @return string
     */
    public function getParler()
    {
        return $this->parler;
    }

    /**
     * Set agent
     *
     * @param \Agent\AgentBundle\Entity\Agent $agent
     *
     * @return Agent_Langue
     */
    public function setAgent(\Agent\AgentBundle\Entity\Agent $agent = null)
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * Get agent
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * Set langue
     *
     * @param \Ecompetence\EcompetenceBundle\Entity\Langue $langue
     *
     * @return Agent_Langue
     */
    public function setLangue(\Ecompetence\EcompetenceBundle\Entity\Langue $langue = null)
    {
        $this->langue = $langue;

        return $this;
    }

    /**
     * Get langue
     *
     * @return \Ecompetence\EcompetenceBundle\Entity\Langue
     */
    public function getLangue()
    {
        return $this->langue;
    }

   /**
     * Set TypeLangue
     *
     * param Entity\TypeLangue $TypeLangue
     *
     * return TypeLangue
     */
    public function setTypeLangue( $TypeLangue = null)
    {
        $this->TypeLangue = $TypeLangue;

        return $this;
    }

    /**
     * Get TypeLangue
     *
     * return Entity\TypeLangue
     */
    public function getTypeLangue()
    {
        return $this->TypeLangue;
    }
}
