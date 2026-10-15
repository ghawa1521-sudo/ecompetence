<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * News
 *
 * @ORM\Table(name="news")
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Repository\NewsRepository")
 */
class News {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecreation", type="datetimetz")
     */
    private $datecreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="debut", type="datetimetz")
     */
    private $debut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fin", type="datetimetz", nullable=true)
     */
    private $fin;

    /**
     * @var string
     *
     * @ORM\Column(name="nature", type="string", length=255)
     */
    private $nature;

    /**
     * @var string
     *
     * @ORM\Column(name="msg", type="text")
     */
    private $msg;

    public function __construct() {
        $this->datecreation = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set datecreation
     *
     * @param \DateTime $datecreation
     * @return News
     */
    public function setDatecreation($datecreation) {
        $this->datecreation = $datecreation;

        return $this;
    }

    /**
     * Get datecreation
     *
     * @return \DateTime
     */
    public function getDatecreation() {
        return $this->datecreation;
    }

    /**
     * Set debut
     *
     * @param \DateTime $debut
     * @return News
     */
    public function setDebut($debut) {
        $this->debut = $debut;

        return $this;
    }

    /**
     * Get debut
     *
     * @return \DateTime
     */
    public function getDebut() {
        return $this->debut;
    }

    /**
     * Set fin
     *
     * @param \DateTime $fin
     * @return News
     */
    public function setFin($fin) {
        $this->fin = $fin;

        return $this;
    }

    /**
     * Get fin
     *
     * @return \DateTime
     */
    public function getFin() {
        return $this->fin;
    }

    /**
     * Set nature
     *
     * @param string $nature
     * @return News
     */
    public function setNature($nature) {
        $this->nature = $nature;

        return $this;
    }

    /**
     * Get nature
     *
     * @return string
     */
    public function getNature() {
        return $this->nature;
    }

    /**
     * Set msg
     *
     * @param string $msg
     * @return News
     */
    public function setMsg($msg) {
        $this->msg = $msg;

        return $this;
    }

    /**
     * Get msg
     *
     * @return string
     */
    public function getMsg() {
        return $this->msg;
    }

}
