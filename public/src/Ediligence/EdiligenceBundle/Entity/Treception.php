<?php

namespace Ediligence\EdiligenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Treception
 *
 * @ORM\Table(name="treception")
 * @ORM\Entity(repositoryClass="Ediligence\EdiligenceBundle\Repository\TreceptionRepository")
 */
class Treception {
    
    
    /**
     * @var integer
     *
     * @ORM\Column(name="Id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateReception", type="datetime", nullable=false)
     */
    private $datereception;

    /**
     * @var integer
     *
     * @ORM\Column(name="etatReception", type="integer", nullable=false)
     */
    private $etatreception = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="matriculeReception", type="string", length=50, nullable=false)
     */
    private $matriculereception;

    /**
     * @var integer
     *
     * @ORM\Column(name="Id_imput", type="integer", nullable=false)
     */
    private $idImput = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="chrono", type="string", length=20, nullable=true)
     */
    private $chrono;

    

    /**
     * @ORM\ManyToOne(targetEntity="Tcourrier", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $courrier;

    
     /**
     * @ORM\ManyToOne(targetEntity="Ttypecourrier", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $typecourrier;

    /**
     * @var string
     *
     * @ORM\Column(name="servicereception", type="string", length=255, nullable=true)
     */
    private $servicereception;
    
    

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
     * Set datereception
     *
     * @param \DateTime $datereception
     *
     * @return Treception
     */
    public function setDatereception($datereception)
    {
        $this->datereception = $datereception;

        return $this;
    }

    /**
     * Get datereception
     *
     * @return \DateTime
     */
    public function getDatereception()
    {
        return $this->datereception;
    }

    /**
     * Set etatreception
     *
     * @param integer $etatreception
     *
     * @return Treception
     */
    public function setEtatreception($etatreception)
    {
        $this->etatreception = $etatreception;

        return $this;
    }

    /**
     * Get etatreception
     *
     * @return integer
     */
    public function getEtatreception()
    {
        return $this->etatreception;
    }

    /**
     * Set matriculereception
     *
     * @param string $matriculereception
     *
     * @return Treception
     */
    public function setMatriculereception($matriculereception)
    {
        $this->matriculereception = $matriculereception;

        return $this;
    }

    /**
     * Get matriculereception
     *
     * @return string
     */
    public function getMatriculereception()
    {
        return $this->matriculereception;
    }

    /**
     * Set idImput
     *
     * @param integer $idImput
     *
     * @return Treception
     */
    public function setIdImput($idImput)
    {
        $this->idImput = $idImput;

        return $this;
    }

    /**
     * Get idImput
     *
     * @return integer
     */
    public function getIdImput()
    {
        return $this->idImput;
    }

    /**
     * Set chrono
     *
     * @param string $chrono
     *
     * @return Treception
     */
    public function setChrono($chrono)
    {
        $this->chrono = $chrono;

        return $this;
    }

    /**
     * Get chrono
     *
     * @return string
     */
    public function getChrono()
    {
        return $this->chrono;
    }

    /**
     * Set servicereception
     *
     * @param string $servicereception
     *
     * @return Treception
     */
    public function setServicereception($servicereception)
    {
        $this->servicereception = $servicereception;

        return $this;
    }

    /**
     * Get servicereception
     *
     * @return string
     */
    public function getServicereception()
    {
        return $this->servicereception;
    }

    /**
     * Set courrier
     *
     * @param \Ediligence\EdiligenceBundle\Entity\Tcourrier $courrier
     *
     * @return Treception
     */
    public function setCourrier(\Ediligence\EdiligenceBundle\Entity\Tcourrier $courrier)
    {
        $this->courrier = $courrier;

        return $this;
    }

    /**
     * Get courrier
     *
     * @return \Ediligence\EdiligenceBundle\Entity\Tcourrier
     */
    public function getCourrier()
    {
        return $this->courrier;
    }

    /**
     * Set typecourrier
     *
     * @param \Ediligence\EdiligenceBundle\Entity\Ttypecourrier $typecourrier
     *
     * @return Treception
     */
    public function setTypecourrier(\Ediligence\EdiligenceBundle\Entity\Ttypecourrier $typecourrier)
    {
        $this->typecourrier = $typecourrier;

        return $this;
    }

    /**
     * Get typecourrier
     *
     * @return \Ediligence\EdiligenceBundle\Entity\Ttypecourrier
     */
    public function getTypecourrier()
    {
        return $this->typecourrier;
    }
}
