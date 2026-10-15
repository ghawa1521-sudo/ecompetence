<?php

namespace Annuaire\AnnuaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ville
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Annuaire\AnnuaireBundle\Entity\villeRepository")
 */
class ville
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;
    
    /**
     * @ORM\ManyToOne(targetEntity="Annuaire\AnnuaireBundle\Entity\Test",  cascade={"persist"})
     * @ORM\JoinColumn(name="pays_delaville", referencedColumnName="id")
     */
    private $pays_delaville;

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
     * Set nom
     *
     * @param string $nom
     *
     * @return ville
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set paysDelaville
     *
     * @param \Annuaire\AnnuaireBundle\Entity\Test $paysDelaville
     *
     * @return ville
     */
    public function setPaysDelaville(\Annuaire\AnnuaireBundle\Entity\Test $paysDelaville = null)
    {
        $this->pays_delaville = $paysDelaville;

        return $this;
    }

    /**
     * Get paysDelaville
     *
     * @return \Annuaire\AnnuaireBundle\Entity\Test
     */
    public function getPaysDelaville()
    {
        return $this->pays_delaville;
    }
    
    public function __toString() {
        return $this->getNom();
    }
}
