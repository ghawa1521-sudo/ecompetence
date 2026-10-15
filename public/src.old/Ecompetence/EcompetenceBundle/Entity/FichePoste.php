<?php

namespace Ecompetence\EcompetenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FichePoste
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ecompetence\EcompetenceBundle\Repository\FichePosteRepository")
 */
class FichePoste
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
     * @ORM\ManyToOne(targetEntity="Competence")
     * @ORM\JoinColumn(name="competence_id", referencedColumnName="id", nullable=true)
     */
    private $competence;
    
     /**
     * @ORM\ManyToOne(targetEntity="Fonctioncompetence")
     * @ORM\JoinColumn(name="fonction_id", referencedColumnName="id", nullable=true)
     */
    private $fonction;   
    
    

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
     * Set competence
     *
     * @param \Ecompetence\EcompetenceBundle\Entity\Competence $competence
     *
     * @return FichePoste
     */
    public function setCompetence(\Ecompetence\EcompetenceBundle\Entity\Competence $competence = null)
    {
        $this->competence = $competence;

        return $this;
    }

    /**
     * Get competence
     *
     * @return \Ecompetence\EcompetenceBundle\Entity\Competence
     */
    public function getCompetence()
    {
        return $this->competence;
    }

    /**
     * Set fonction
     *
     * @param \Ecompetence\EcompetenceBundle\Entity\Fonctioncompetence $fonction
     *
     * @return FichePoste
     */
    public function setFonction(\Ecompetence\EcompetenceBundle\Entity\Fonctioncompetence $fonction = null)
    {
        $this->fonction = $fonction;

        return $this;
    }

    /**
     * Get fonction
     *
     * @return \Ecompetence\EcompetenceBundle\Entity\Fonctioncompetence
     */
    public function getFonction()
    {
        return $this->fonction;
    }
}
