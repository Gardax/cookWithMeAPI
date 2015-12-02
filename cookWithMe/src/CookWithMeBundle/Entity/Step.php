<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 11/22/15
 * Time: 3:49 PM
 */

namespace CookWithMeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="steps")
 */
class Step
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text")
     */
    protected $action;

    /**
     * @ORM\Column(type="integer")
     */
    protected $estimatedTime;

    /**
     * @ORM\ManyToOne(targetEntity="Recipe")
     * @ORM\JoinColumn(name="recipe_id", referencedColumnName="id")
     */
    protected $recipe;

    /**
     * @return mixed
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * @param mixed $recipe
     */
    public function setRecipe($recipe)
    {
        $this->recipe = $recipe;
    }

    public function __construct() {
        $this->recipes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Get action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set action
     * @param string $action
     *
     * return Step
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * Get estimatedTime
     *
     * @return integer
     */
    public function getEstimatedTime()
    {
        return $this->estimatedTime;
    }

    /**
     * Set estimatedTime
     *
     * @param integer $estimatedTime
     *
     * return Step
     */
    public function setEstimatedTime($estimatedTime)
    {
        $this->estimatedTime = $estimatedTime;
    }

}