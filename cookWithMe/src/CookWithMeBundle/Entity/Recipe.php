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
     * @ORM\Column(type="boolean")
     */
    protected $isPublic;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isApproved;

    /**
     * @ORM\OneToMany(targetEntity="Step", mappedBy="recipe")
     */
    protected $steps;

    /**
     * @ORM\ManyToMany(targetEntity="Ingredient", inversedBy="recipes")
     * @ORM\JoinTable(name="recipes_ingredients")
     */
    protected $ingredients;

    /**
     * @ORM\OneToMany(targetEntity="Rating", mappedBy="recipe")
     */
    protected $ratings;

    public function __construct() {
        $this->steps = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ingredients = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ratings = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param $steps
     */
    public function setSteps($steps){
        $this->steps = $steps;
    }

    /**
     * @return mixed
     */
    public function getIsPublic()
    {
        return $this->isPublic;
    }

    /**
     * @param mixed $isPublic
     */
    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;
    }

    /**
     * @return mixed
     */
    public function getIsApproved()
    {
        return $this->isApproved;
    }

    /**
     * @param mixed $isApproved
     */
    public function setIsApproved($isApproved)
    {
        $this->isApproved = $isApproved;
    }

    /**
     * @param Ingredient $ingredient
     */
    public function addIngredient(Ingredient $ingredient){
        $this->ingredients[] = $ingredient;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getIngredients(){
        return $this->ingredients;
    }

    /**
     * @param $ingredients
     */
    public function setIngredients($ingredients){
        $this->ingredients = $ingredients;
    }
}
