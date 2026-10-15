<?php

namespace Users\UsersBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class Users extends BaseUser {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Agent\AgentBundle\Entity\Agent", inversedBy="users")
     * @ORM\JoinColumn(name="agent_id", referencedColumnName="id", nullable=true)
     */
    private $agent;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255, nullable=true)
     */
    protected $token;

    /**
     * @var integer
     *
     * @ORM\Column(name="etat", type="integer", nullable=true)
     */
    private $etat = null; //0 menu admin , 1 menu utilisateur

    /**
     * Plain password. Used for model validation. Must not be persisted.
     * @Assert\Regex(
     *  pattern="/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{8,}/",
     *  message="Le mot de passe doit contenir au minimum: 8 Caractères, une lettre majuscule, et un chiffre."
     * )
     * @var string
     */
    protected $plainPassword;

    /**
     * @var integer
     *
     * @ORM\Column(name="etatConnexion", type="integer", nullable=true)
     */
    private $etatConnexion = 0; //0 menu admin , 1 menu utilisateur

    public function __construct() {
        parent::__construct();
        // your own logic
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return Users
     */
    public function setToken($token) {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken() {
        return $this->token;
    }

    /**
     * Set agent
     *
     * @param \Agent\AgentBundle\Entity\Agent $agent
     *
     * @return Users
     */
    public function setAgent(\Agent\AgentBundle\Entity\Agent $agent = null) {
        $this->agent = $agent;

        return $this;
    }

    /**
     * Get agent
     *
     * @return \Agent\AgentBundle\Entity\Agent
     */
    public function getAgent() {
        return $this->agent;
    }

    /**
     * Set etat
     *
     * @param integer $etat
     *
     * @return Users
     */
    public function setEtat($etat) {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return integer
     */
    public function getEtat() {
        return $this->etat;
    }

    /**
     * Set etatConnexion
     *
     * @param integer $etatConnexion
     *
     * @return Users
     */
    public function setEtatConnexion($etatConnexion) {
        $this->etatConnexion = $etatConnexion;

        return $this;
    }

    /**
     * Get etatConnexion
     *
     * @return integer
     */
    public function getEtatConnexion() {
        return $this->etatConnexion;
    }

}
