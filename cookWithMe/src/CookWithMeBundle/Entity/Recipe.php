<?php
/**
 * Created by PhpStorm.
 * User: gardax
 * Date: 11/21/15
 * Time: 4:17 PM
 */

namespace CookWithMeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="recipes")
 */
class Recipe {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=250)
     */
    protected $title;

    /**
     * @ORM\OneToMany(targetEntity="Step", mappedBy="recipe")
     */
    protected $steps;

    /**
     * @ORM\ManyToMany(targetEntity="Ingredient", inversedBy="recipes")
     * @ORM\JoinTable(name="recipes_ingredients")
     */
    protected $ingredients;

    public function __construct() {
        $this->steps = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ingredients = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     *
     * @return Recipe
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param Step $step
     */
    public function addStep(Step $step){
        $this->steps[] = $step;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getSteps() {
        return $this->steps;
    }

    /**
     * @param Ingredient $ingredient
     */
    public function addIngredient(Ingredient $ingredient){
        $this->ingredients[] = $ingredient;
    }

    public function getIngredients(){
        return $this->ingredients;
    }
}
