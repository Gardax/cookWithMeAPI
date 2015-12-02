<?php

namespace CookWithMeBundle\Models;


use CookWithMeBundle\Entity\Recipe;

/**
 * Class RecipeModel
 * @package CookWithMeBundle\Models
 */
class RecipeModel {
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var StepModel
     */
    public $steps;

    /**
     * @var IngredientModel
     */
    public $ingredients;

    /**
     * @var boolean
     */
    public $isPublic;

    /**
     * @var boolean
     */
    public $isApproved;


    function __construct(Recipe $recipe)
    {
        $this->id = $recipe->getId();
        $this->title = $recipe->getTitle();

        $this->steps = [];
        foreach($recipe->getSteps() as $step) {
            $this->steps[] = new StepModel($step);
        }

        $this->ingredients = [];
        foreach($recipe->getIngredients() as $ingredient){
            $this->ingredients[] = new IngredientModel($ingredient);
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return boolean
     */
    public function isIsPublic()
    {
        return $this->isPublic;
    }

    /**
     * @param boolean $isPublic
     */
    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;
    }

    /**
     * @return boolean
     */
    public function isIsApproved()
    {
        return $this->isApproved;
    }

    /**
     * @param boolean $isApproved
     */
    public function setIsApproved($isApproved)
    {
        $this->isApproved = $isApproved;
    }

}