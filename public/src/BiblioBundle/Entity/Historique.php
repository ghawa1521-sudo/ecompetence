<?php

namespace BiblioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Historique
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="BiblioBundle\Repository\HistoriqueRepository")
 */
class Historique
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    
    
      /**
     * @ORM\ManyToOne(targetEntity="Bouquin")
     */
    private $bouquin;
    
    /**
    * @ORM\ManyToOne(targetEntity="Users\UsersBundle\Entity\Users")
    */
    private $user;

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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Historique
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set bouquin
     *
     * @param \BiblioBundle\Entity\Bouquin $bouquin
     *
     * @return Historique
     */
    public function setBouquin(\BiblioBundle\Entity\Bouquin $bouquin = null)
    {
        $this->bouquin = $bouquin;

        return $this;
    }

    /**
     * Get bouquin
     *
     * @return \BiblioBundle\Entity\Bouquin
     */
    public function getBouquin()
    {
        return $this->bouquin;
    }

    /**
     * Set user
     *
     * @param \Users\UsersBundle\Entity\Users $user
     *
     * @return Historique
     */
    public function setUser(\Users\UsersBundle\Entity\Users $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Users\UsersBundle\Entity\Users
     */
    public function getUser()
    {
        return $this->user;
    }
}
