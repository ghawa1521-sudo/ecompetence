<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Adresse
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Adresse {

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
     * @ORM\Column(name="email", type="string", length=100)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = false
     * )
     */
    private $email;

    /**
     * @var Personnes|null
     *
     * @ORM\ManyToOne(targetEntity="Agent", inversedBy="adresse",cascade={"persist"})
     * @ORM\JoinColumn(name="agent", referencedColumnName="id", nullable=true)
     */
    protected $agent;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Adresse
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set agent
     *
     * @param \Agent\AgentBundle\Entity\Agent $agent
     *
     * @return Adresse
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

}
