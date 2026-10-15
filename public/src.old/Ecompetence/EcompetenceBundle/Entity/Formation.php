<?php

namespace Ecompetence\EcompetenceBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;


/**
 * Formation
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ecompetence\EcompetenceBundle\Repository\FormationRepository")
 */
class Formation
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
     * @ORM\Column(name="LibFormation", type="string", length=125,nullable=true)
     */
    private $libFormation;

    /**
     * @ORM\ManyToOne(targetEntity="Niveau")
     * @ORM\JoinColumn(name="niveau_id", referencedColumnName="id", nullable=true)
     * 
     */

    private $niveauFormation;

    /**
     * @ORM\ManyToOne(targetEntity="Diplome")
     * @ORM\JoinColumn(name="diplome_id", referencedColumnName="id", nullable=true)
     * 
     */
    private $diplome;

    /**
     * @ORM\ManyToOne(targetEntity="Specialite")
     * @ORM\JoinColumn(name="specialite_id", referencedColumnName="id", nullable=true)
     */
    private $specialite;

    /**
     * @var \Datetime
     * @Assert\LessThanOrEqual(
     *      value = "today",
     *      message = "Impossible de choisir une date du futur"
     * )
     * @ORM\Column(name="DateObtentiondiplo", type="date", nullable=true)
     * @Assert\NotNull(message="Veuillez renseigner la date début",groups={"DIPLOMANTE"} )
     */

    private $dateObtentiondiplo;

    /**
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Agent", inversedBy="formation")
     * @ORM\JoinColumn(name="agent_id", referencedColumnName="id", nullable=true)
     */
    private $agent;

    /**
     * @ORM\ManyToOne(targetEntity="Etablissement")
     * @ORM\JoinColumn(name="etablissement_id", referencedColumnName="id", nullable=true)
     */
    private $etablissement;

    /**
     * @var string
     *
     * @ORM\Column(name="autreetab", type="string", length=125,nullable=true)
     */
    private $autreetablissement;

    /**
     * @ORM\ManyToOne(targetEntity="Typeformation")
     * @ORM\JoinColumn(name="typeformation_id", referencedColumnName="id", nullable=true)
     */
    private $typeformation;

    /**
     * @ORM\ManyToOne(targetEntity="Optiondiplome")
     * @ORM\JoinColumn(name="option_id", referencedColumnName="id", nullable=true)
     */

    private $option;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="Agent\AgentBundle\Entity\Pj", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     * 
     */
    private $pj;


    /**
     * @var integer
     *
     * @ORM\Column(name="etat", type="integer",nullable=true)
     */
    private $etat;



    /**
     * @var \DateTime
     * @ORM\Column(name="date_debut", type="date", nullable=true)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_fin", type="date", nullable=true)
     */
    private $dateFin;


    public function setDateDebut(\DateTime $dateDebut = null)
    {
        $this->dateDebut = $dateDebut;
        return $this;
    }

    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    public function setDateFin(\DateTime $dateFin = null)
    {
        $this->dateFin = $dateFin;
        return $this;
    }

    public function getDateFin()
    {
        return $this->dateFin;
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
     * Set libFormation
     *
     * @param string $libFormation
     *
     * @return Formation
     */
    public function setLibFormation($libFormation)
    {
        $this->libFormation = $libFormation;

        return $this;
    }

    /**
     * Get libFormation
     *
     * @return string
     */
    public function getLibFormation()
    {
        return $this->libFormation;
    }

    /**
     * Set dateObtentiondiplo
     *
     * @param \DateTime $dateObtentiondiplo
     *
     * @return Formation
     */
    public function setDateObtentiondiplo($dateObtentiondiplo)
    {
        $this->dateObtentiondiplo = $dateObtentiondiplo;

        return $this;
    }

    /**
     * Get dateObtentiondiplo
     *
     * @return \DateTime
     */
    public function getDateObtentiondiplo()
    {
        return $this->dateObtentiondiplo;
    }

    /**
     * Set autreetablissement
     *
     * @param string $autreetablissement
     *
     * @return Formation
     */
    public function setAutreetablissement($autreetablissement)
    {
        $this->autreetablissement = $autreetablissement;

        return $this;
    }

    /**
     * Get autreetablissement
     *
     * @return string
     */
    public function getAutreetablissement()
    {
        return $this->autreetablissement;
    }

    /**
     * Set niveauFormation
     *
     * @param \Ecompetence\EcompetenceBundle\Entity\Niveau $niveauFormation
     *
     * @return Formation
     */
    public function setNiveauFormation(\Ecompetence\EcompetenceBundle\Entity\Niveau $niveauFormation = null)
    {
        $this->niveauFormation = $niveauFormation;

        return $this;
    }

    /**
     * Get niveauFormation
     *
     * @return \Ecompetence\EcompetenceBundle\Entity\Niveau
     */
    public function getNiveauFormation()
    {
        return $this->niveauFormation;
    }

    /**
     * Set diplome
     *
     * @param \Ecompetence\EcompetenceBundle\Entity\Diplome $diplome
     *
     * @return Formation
     */
    public function setDiplome(\Ecompetence\EcompetenceBundle\Entity\Diplome $diplome = null)
    {
        $this->diplome = $diplome;

        return $this;
    }

    /**
     * Get diplome
     *
     * @return \Ecompetence\EcompetenceBundle\Entity\Diplome
     */
    public function getDiplome()
    {
        return $this->diplome;
    }

    /**
     * Set specialite
     *
     * @param \Ecompetence\EcompetenceBundle\Entity\Specialite $specialite
     *
     * @return Formation
     */
    public function setSpecialite(\Ecompetence\EcompetenceBundle\Entity\Specialite $specialite = null)
    {
        $this->specialite = $specialite;

        return $this;
    }

    /**
     * Get specialite
     *
     * @return \Ecompetence\EcompetenceBundle\Entity\Specialite
     */
    public function getSpecialite()
    {
        return $this->specialite;
    }

    /**
     * Set agent
     *
     * @param \Agent\AgentBundle\Entity\Agent $agent
     *
     * @return Formation
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
     * Set etablissement
     *
     * @param \Ecompetence\EcompetenceBundle\Entity\Etablissement $etablissement
     *
     * @return Formation
     */
    public function setEtablissement(\Ecompetence\EcompetenceBundle\Entity\Etablissement $etablissement = null)
    {
        $this->etablissement = $etablissement;

        return $this;
    }

    /**
     * Get etablissement
     *
     * @return \Ecompetence\EcompetenceBundle\Entity\Etablissement
     */
    public function getEtablissement()
    {
        return $this->etablissement;
    }

    /**
     * Set typeformation
     *
     * @param \Ecompetence\EcompetenceBundle\Entity\Typeformation $typeformation
     *
     * @return Formation
     */
    public function setTypeformation(\Ecompetence\EcompetenceBundle\Entity\Typeformation $typeformation = null)
    {
        $this->typeformation = $typeformation;

        return $this;
    }

    /**
     * Get typeformation
     *
     * @return \Ecompetence\EcompetenceBundle\Entity\Typeformation
     */
    public function getTypeformation()
    {
        return $this->typeformation;
    }

    /**
     * Set option
     *
     * @param \Ecompetence\EcompetenceBundle\Entity\Optiondiplome $option
     *
     * @return Formation
     */
    public function setOption(\Ecompetence\EcompetenceBundle\Entity\Optiondiplome $option = null)
    {
        $this->option = $option;

        return $this;
    }

    /**
     * Get option
     *
     * @return \Ecompetence\EcompetenceBundle\Entity\Optiondiplome
     */
    public function getOption()
    {
        return $this->option;
    }



    /**
     * Set etat
     *
     * @param integer $etat
     *
     * @return Formation
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return integer
     */
    public function getEtat()
    {
        return $this->etat;
    }


    /**
     * Set pj
     *
     * @param \Agent\AgentBundle\Entity\Pj $pj
     *
     * @return Formation
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
