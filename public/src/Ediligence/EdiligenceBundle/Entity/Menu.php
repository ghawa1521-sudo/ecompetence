<?php

namespace Ediligence\EdiligenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 *
 * @ORM\Table(name="menu")
 * @ORM\Entity(repositoryClass="Ediligence\EdiligenceBundle\Repository\MenuRepository")
 */
class Menu
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_menu", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="Lbl_menu", type="string", length=500, nullable=false)
     */
    private $lblMenu;

    /**
     * @var string
     *
     * @ORM\Column(name="Typecompte", type="string", length=1000, nullable=true)
     */
    private $typecompte;

    /**
     * @var string
     *
     * @ORM\Column(name="Lien_menu", type="string", length=200, nullable=false)
     */
    private $lienMenu;

    /**
     * @var string
     *
     * @ORM\Column(name="class_lien", type="string", length=200, nullable=true)
     */
    private $classLien;

    /**
     * @var integer
     *
     * @ORM\Column(name="Ordre", type="integer", nullable=false)
     */
    private $ordre = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="Actif_menu", type="integer", nullable=false)
     */
    private $actifMenu = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="Cat_menu", type="string", length=10, nullable=false)
     */
    private $catMenu = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="Param", type="integer", nullable=false)
     */
    private $param = '0';

    
    /**
     * @var string
     *
     * @ORM\Column(name="countval", type="string", length=200, nullable=true)
     */
    private $countval;
    

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
     * Set lblMenu
     *
     * @param string $lblMenu
     *
     * @return Menu
     */
    public function setLblMenu($lblMenu)
    {
        $this->lblMenu = $lblMenu;

        return $this;
    }

    /**
     * Get lblMenu
     *
     * @return string
     */
    public function getLblMenu()
    {
        return $this->lblMenu;
    }

    /**
     * Set typecompte
     *
     * @param string $typecompte
     *
     * @return Menu
     */
    public function setTypecompte($typecompte)
    {
        $this->typecompte = $typecompte;

        return $this;
    }

    /**
     * Get typecompte
     *
     * @return string
     */
    public function getTypecompte()
    {
        return $this->typecompte;
    }

    /**
     * Set lienMenu
     *
     * @param string $lienMenu
     *
     * @return Menu
     */
    public function setLienMenu($lienMenu)
    {
        $this->lienMenu = $lienMenu;

        return $this;
    }

    /**
     * Get lienMenu
     *
     * @return string
     */
    public function getLienMenu()
    {
        return $this->lienMenu;
    }

    /**
     * Set classLien
     *
     * @param string $classLien
     *
     * @return Menu
     */
    public function setClassLien($classLien)
    {
        $this->classLien = $classLien;

        return $this;
    }

    /**
     * Get classLien
     *
     * @return string
     */
    public function getClassLien()
    {
        return $this->classLien;
    }

    /**
     * Set ordre
     *
     * @param integer $ordre
     *
     * @return Menu
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * Get ordre
     *
     * @return integer
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Set actifMenu
     *
     * @param integer $actifMenu
     *
     * @return Menu
     */
    public function setActifMenu($actifMenu)
    {
        $this->actifMenu = $actifMenu;

        return $this;
    }

    /**
     * Get actifMenu
     *
     * @return integer
     */
    public function getActifMenu()
    {
        return $this->actifMenu;
    }

    /**
     * Set catMenu
     *
     * @param string $catMenu
     *
     * @return Menu
     */
    public function setCatMenu($catMenu)
    {
        $this->catMenu = $catMenu;

        return $this;
    }

    /**
     * Get catMenu
     *
     * @return string
     */
    public function getCatMenu()
    {
        return $this->catMenu;
    }

    /**
     * Set param
     *
     * @param integer $param
     *
     * @return Menu
     */
    public function setParam($param)
    {
        $this->param = $param;

        return $this;
    }

    /**
     * Get param
     *
     * @return integer
     */
    public function getParam()
    {
        return $this->param;
    }

    /**
     * Set countval
     *
     * @param string $countval
     *
     * @return Menu
     */
    public function setCountval($countval)
    {
        $this->countval = $countval;

        return $this;
    }

    /**
     * Get countval
     *
     * @return string
     */
    public function getCountval()
    {
        return $this->countval;
    }
}
