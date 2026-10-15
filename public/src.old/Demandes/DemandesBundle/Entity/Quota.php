<?php

namespace Demandes\DemandesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Quota
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Demandes\DemandesBundle\Entity\QuotaRepository")
 */
class Quota
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
     * @var integer
     *
     * @ORM\Column(name="nbreQuota", type="integer")
     */
    private $nbreQuota;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbreJoursAvant", type="integer")
     */
    private $nbreJoursAvant;

   
    /**
     * @ORM\ManyToOne(targetEntity="TypeDemande",  cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeDemande;

    /**
     * @ORM\ManyToOne(targetEntity="PeriodeQuota",  cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $periode;

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
     * Set nbreQuota
     *
     * @param integer $nbreQuota
     *
     * @return Quota
     */
    public function setNbreQuota($nbreQuota)
    {
        $this->nbreQuota = $nbreQuota;

        return $this;
    }

    /**
     * Get nbreQuota
     *
     * @return integer
     */
    public function getNbreQuota()
    {
        return $this->nbreQuota;
    }

    /**
     * Set typeDemande
     *
     * @param \Demandes\DemandesBundle\Entity\TypeDemande $typeDemande
     *
     * @return Quota
     */
    public function setTypeDemande(\Demandes\DemandesBundle\Entity\TypeDemande $typeDemande)
    {
        $this->typeDemande = $typeDemande;

        return $this;
    }

    /**
     * Get typeDemande
     *
     * @return \Demandes\DemandesBundle\Entity\TypeDemande
     */
    public function getTypeDemande()
    {
        return $this->typeDemande;
    }

    /**
     * Set periode
     *
     * @param \Demandes\DemandesBundle\Entity\PeriodeQuota $periode
     *
     * @return Quota
     */
    public function setPeriode(\Demandes\DemandesBundle\Entity\PeriodeQuota $periode)
    {
        $this->periode = $periode;

        return $this;
    }

    /**
     * Get periode
     *
     * @return \Demandes\DemandesBundle\Entity\PeriodeQuota
     */
    public function getPeriode()
    {
        return $this->periode;
    }

    /**
     * Set nbreJoursAvant
     *
     * @param integer $nbreJoursAvant
     *
     * @return Quota
     */
    public function setNbreJoursAvant($nbreJoursAvant)
    {
        $this->nbreJoursAvant = $nbreJoursAvant;

        return $this;
    }

    /**
     * Get nbreJoursAvant
     *
     * @return integer
     */
    public function getNbreJoursAvant()
    {
        return $this->nbreJoursAvant;
    }

  
}
