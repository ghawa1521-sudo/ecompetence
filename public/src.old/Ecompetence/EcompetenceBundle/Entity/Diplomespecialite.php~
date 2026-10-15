<?php

namespace Ecompetence\EcompetenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Diplomespecialite
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Diplomespecialite
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
     * @ORM\ManyToOne(targetEntity="Diplome")
     * @ORM\JoinColumn(name="diplome_id", referencedColumnName="id", nullable=true)
     */
     private $diplome;

      /**
     * @ORM\ManyToOne(targetEntity="Specialite")
     * @ORM\JoinColumn(name="specialite_id", referencedColumnName="id", nullable=true)
     */
     private $specialite;



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
     * Set diplome
     *
     * @param \Ecompetence\EcompetenceBundle\Entity\Diplome $diplome
     *
     * @return Diplomespecialite
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
     * Set speciliate
     *
     * @param \Ecompetence\EcompetenceBundle\Entity\Specialite $speciliate
     *
     * @return Diplomespecialite
     */
    public function setSpecialite(\Ecompetence\EcompetenceBundle\Entity\Specialite $specialite = null)
    {
        $this->specialite = $specialite;

        return $this;
    }

    /**
     * Get speciliate
     *
     * @return \Ecompetence\EcompetenceBundle\Entity\Specialite
     */
    public function getSpecialite()
    {
        return $this->specialite;
    }
}
