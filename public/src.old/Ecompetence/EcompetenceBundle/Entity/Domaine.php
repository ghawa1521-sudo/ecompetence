<?php

namespace Ecompetence\EcompetenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Domaine
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ecompetence\EcompetenceBundle\Repository\DomaineRepository")
 */
class Domaine
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
     * @ORM\Column(name="LibDomaine", type="string", length=250)
     */
    private $libDomaine;
    
      /**
     * @var string
     *
     * @ORM\Column(name="Level", type="integer",nullable=true)
     */
    private $level;
  
    /**
     * @ORM\OneToMany(targetEntity="Domaine", mappedBy="parent")
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="Domaine", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id",nullable=true)
     */
    private $parent;

    public function __construct() {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function __toString() {
        return $this->getLibDomaine();
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
     * Set libDomaine
     *
     * @param string $libDomaine
     *
     * @return Domaine
     */
    public function setLibDomaine($libDomaine)
    {
        $this->libDomaine = $libDomaine;

        return $this;
    }

    /**
     * Get libDomaine
     *
     * @return string
     */
    public function getLibDomaine()
    {
        return $this->libDomaine;
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return Domaine
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Add child
     *
     * @param \Ecompetence\EcompetenceBundle\Entity\Domaine $child
     *
     * @return Domaine
     */
    public function addChild(\Ecompetence\EcompetenceBundle\Entity\Domaine $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \Ecompetence\EcompetenceBundle\Entity\Domaine $child
     */
    public function removeChild(\Ecompetence\EcompetenceBundle\Entity\Domaine $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \Ecompetence\EcompetenceBundle\Entity\Domaine $parent
     *
     * @return Domaine
     */
    public function setParent(\Ecompetence\EcompetenceBundle\Entity\Domaine $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Ecompetence\EcompetenceBundle\Entity\Domaine
     */
    public function getParent()
    {
        return $this->parent;
    }
}
