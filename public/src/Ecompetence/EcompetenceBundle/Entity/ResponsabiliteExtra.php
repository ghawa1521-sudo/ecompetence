<?php

namespace Ecompetence\EcompetenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Langue
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class ResponsabiliteExtra
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
     * @ORM\Column(name="librespo", type="string", length=255)
     */
    private $librespo;

     


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
     * Set librespo
     *
     * @param string $librespo
     *
     * @return ResponsabiliteExtra
     */
    public function setLibrespo($librespo)
    {
        $this->librespo = $librespo;

        return $this;
    }

    /**
     * Get librespo
     *
     * @return string
     */
    public function getLibrespo()
    {
        return $this->librespo;
    }

    
}
