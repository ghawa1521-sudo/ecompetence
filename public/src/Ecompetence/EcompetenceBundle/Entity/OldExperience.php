<?php

namespace Ecompetence\EcompetenceBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;

/**
 * Experience
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ecompetence\EcompetenceBundle\Repository\ExperienceRepository")
 * @Vich\Uploadable
 */
class OldExperience
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
     * @ORM\Column(name="LibExp", type="string", length=255,nullable=true)
     */
    private $libExp;

     /**
     * @var \DateTime
     * @Assert\LessThanOrEqual(
     *      value = "today",
     *      message = "Impossible de choisir une date du futur"
     * )
     * @ORM\Column(name="DateDebExp", type="date")
     * @Assert\NotNull(message="Veuillez renseigner la date début")
     */
    private $dateDebExp;

     /**
     * @var \Datetime
    
     * @Assert\LessThanOrEqual(
     *      value = "today",
     *      message = "Impossible de choisir une date du futur"
     * )
      * @Assert\Expression("this.validation_date()",message="Date de Début doit être antérieure à celle de fin")
     * @ORM\Column(name="DateFinExp", type="date",nullable=true)
     */
    private $dateFinExp;



    
    
    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent", inversedBy="experience")
     * @ORM\JoinColumn(name="agent_id", referencedColumnName="id", nullable=true)
     */
    private $agent;
    
    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Fonction")
     * @ORM\JoinColumn(name="fonction_id", referencedColumnName="id", nullable=true)
     */
    private $fonction;
   
        /**
     * @ORM\ManyToOne(targetEntity="Structure")
     * @ORM\JoinColumn(name="structure_id", referencedColumnName="id", nullable=true)
     * @Assert\NotNull(message="Choissez le nom de l'employeur ")
     */
    private $structure; 
    
        /**
     * @var string
     *
     * @ORM\Column(name="autrestructure", type="string", length=255,nullable=true)
     */
    private $autrestructure;
    
    /**
     * @ORM\ManyToOne(targetEntity="Cv_directiongle")
     * @ORM\JoinColumn(name="cv_directiongle_id", referencedColumnName="id", nullable=true)
     */
    private $cvdirectiongle ;
    
     /**
     * @ORM\ManyToOne(targetEntity="Cv_direction")
     * @ORM\JoinColumn(name="cv_direction_id", referencedColumnName="id", nullable=true)
     */
    private $cvdirection ;
   
      /**
     * @ORM\ManyToOne(targetEntity="Secteur")
     * @ORM\JoinColumn(name="secteur_id", referencedColumnName="id", nullable=true)
     */
    private $secteur; 

    /**
     * 
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Pj", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $pj;
    
     /**
     * @var string
     *
     * @ORM\Column(name="mission", type="text", length=10000,nullable=true)
     * @Assert\NotNull(message="Veuillez préciser les missions ")
     */
    private $mission;
    
   

    
    



    public function validation_date()
    {  
       if ($this->getDateFinExp()==null)
       {
         $retour= true;
       }
       elseif ($this->getDateFinExp() < $this->getDateDebExp()) {
         $retour= false;

       }
       else
       {
         $retour= true;
       }
        
       return $retour;
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
     * Set libExp
     *
     * @param string $libExp
     *
     * @return Experience
     */
    public function setLibExp($libExp)
    {
        $this->libExp = $libExp;

        return $this;
    }

    /**
     * Get libExp
     *
     * @return string
     */
    public function getLibExp()
    {
        return $this->libExp;
    }

    /**
     * Set dateDebExp
     *
     * @param \DateTime $dateDebExp
     *
     * @return Experience
     */
    public function setDateDebExp($dateDebExp)
    {
        $this->dateDebExp = $dateDebExp;

        return $this;
    }

    /**
     * Get dateDebExp
     *
     * @return \DateTime
     */
    public function getDateDebExp()
    {
        return $this->dateDebExp;
    }

    /**
     * Set dateFinExp
     *
     * @param \DateTime $dateFinExp
     *
     * @return Experience
     */
    public function setDateFinExp($dateFinExp)
    {
        $this->dateFinExp = $dateFinExp;

        return $this;
    }

    /**
     * Get dateFinExp
     *
     * @return \DateTime
     */
    public function getDateFinExp()
    {
        return $this->dateFinExp;
    }

    /**
     * Set autrestructure
     *
     * @param string $autrestructure
     *
     * @return Experience
     */
    public function setAutrestructure($autrestructure)
    {
        $this->autrestructure = $autrestructure;

        return $this;
    }

    /**
     * Get autrestructure
     *
     * @return string
     */
    public function getAutrestructure()
    {
        return $this->autrestructure;
    }

    /**
     * Set mission
     *
     * @param string $mission
     *
     * @return Experience
     */
    public function setMission($mission)
    {
        $this->mission = $mission;

        return $this;
    }

    /**
     * Get mission
     *
     * @return string
     */
    public function getMission()
    {
        return $this->mission;
    }

    /**
     * Set agent
     *
     * @param \Agent\AgentBundle\Entity\Agent $agent
     *
     * @return Experience
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
     * Set fonction
     *
     * @param \Agent\AgentBundle\Entity\Fonction $fonction
     *
     * @return Experience
     */
    public function setFonction(\Agent\AgentBundle\Entity\Fonction $fonction = null)
    {
        $this->fonction = $fonction;

        return $this;
    }

    /**
     * Get fonction
     *
     * @return \Agent\AgentBundle\Entity\Fonction
     */
    public function getFonction()
    {
        return $this->fonction;
    }

    /**
     * Set structure
     *
     * @param \Ecompetence\EcompetenceBundle\Entity\Structure $structure
     *
     * @return Experience
     */
    public function setStructure(\Ecompetence\EcompetenceBundle\Entity\Structure $structure = null)
    {
        $this->structure = $structure;

        return $this;
    }

    /**
     * Get structure
     *
     * @return \Ecompetence\EcompetenceBundle\Entity\Structure
     */
    public function getStructure()
    {
        return $this->structure;
    }

    /**
     * Set cvdirectiongle
     *
     * @param \Ecompetence\EcompetenceBundle\Entity\Cv_directiongle $cvdirectiongle
     *
     * @return Experience
     */
    public function setCvdirectiongle(\Ecompetence\EcompetenceBundle\Entity\Cv_directiongle $cvdirectiongle = null)
    {
        $this->cvdirectiongle = $cvdirectiongle;

        return $this;
    }

    /**
     * Get cvdirectiongle
     *
     * @return \Ecompetence\EcompetenceBundle\Entity\Cv_directiongle
     */
    public function getCvdirectiongle()
    {
        return $this->cvdirectiongle;
    }

    /**
     * Set cvdirection
     *
     * @param \Ecompetence\EcompetenceBundle\Entity\Cv_direction $cvdirection
     *
     * @return Experience
     */
    public function setCvdirection(\Ecompetence\EcompetenceBundle\Entity\Cv_direction $cvdirection = null)
    {
        $this->cvdirection = $cvdirection;

        return $this;
    }

    /**
     * Get cvdirection
     *
     * @return \Ecompetence\EcompetenceBundle\Entity\Cv_direction
     */
    public function getCvdirection()
    {
        return $this->cvdirection;
    }

    /**
     * Set secteur
     *
     * @param \Ecompetence\EcompetenceBundle\Entity\Secteur $secteur
     *
     * @return Experience
     */
    public function setSecteur(\Ecompetence\EcompetenceBundle\Entity\Secteur $secteur = null)
    {
        $this->secteur = $secteur;

        return $this;
    }

    /**
     * Get secteur
     *
     * @return \Ecompetence\EcompetenceBundle\Entity\Secteur
     */
    public function getSecteur()
    {
        return $this->secteur;
    }

    /**
     * Set pj
     *
     * @param \Agent\AgentBundle\Entity\Pj $pj
     *
     * @return Experience
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


     

    
    
}
