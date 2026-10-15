<?php

namespace PasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Budget
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PasBundle\Repository\BudgetRepository")
 */
class Budget
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
     * @ORM\Column(name="budget", type="string", length=255)
     */
    private $budget;

    
   


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
     * Set budget
     *
     * @param string $budget
     *
     * @return Budget
     */
    public function setBudget($budget)
    {
        $this->budget = $budget;

        return $this;
    }

    /**
     * Get budget
     *
     * @return string
     */
    public function getBudget()
    {
        return $this->budget;
    }
}
