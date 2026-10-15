<?php

namespace Agent\AgentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RoleAgent
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Agent\AgentBundle\Repository\RoleAgentRepository")
 */
class RoleAgent
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
     * @ORM\Column(name="libRole", type="string", length=50)
     */
    private $libRole;
    
    /**
     * @var string
     *
     * @ORM\Column(name="roleBase", type="string", length=50)
     */
    private $roleBase;


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
     * Set libRole
     *
     * @param string $libRole
     *
     * @return RoleAgent
     */
    public function setLibRole($libRole)
    {
        $this->libRole = $libRole;

        return $this;
    }

    /**
     * Get libRole
     *
     * @return string
     */
    public function getLibRole()
    {
        return $this->libRole;
    }
     public function __toString()
    {
        return $this->getLibRole();
    }

    /**
     * Set roleBase
     *
     * @param string $roleBase
     *
     * @return RoleAgent
     */
    public function setRoleBase($roleBase)
    {
        $this->roleBase = $roleBase;

        return $this;
    }

    /**
     * Get roleBase
     *
     * @return string
     */
    public function getRoleBase()
    {
        return $this->roleBase;
    }
}
