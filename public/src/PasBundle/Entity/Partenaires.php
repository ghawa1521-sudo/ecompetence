<?php

namespace PasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Partenaires
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PasBundle\Repository\PartenairesRepository")
 */
class Partenaires
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
     * @ORM\Column(name="nompart", type="string", length=500)
     */
    private $nompart;

  
    
  

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
     * Set nompart
     *
     * @param string $nompart
     *
     * @return Partenaires
     */
    public function setNompart($nompart)
    {
        $this->nompart = $nompart;

        return $this;
    }

    /**
     * Get nompart
     *
     * @return string
     */
    public function getNompart()
    {
        return $this->nompart;
    }
}
