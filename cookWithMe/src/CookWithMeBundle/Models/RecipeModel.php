<?php

namespace CookWithMeBundle\Models;


use CookWithMeBundle\Entity\Recipe;

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
     * @var int
     */
    public $cookTime;


    function __construct(Recipe $recipe)
    {
        $this->id = $recipe->getId();
        $this->title = $recipe->getTitle();
        $this->cookTime = $recipe->getCookTime();
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
     * @return int
     */
    public function getCookTime()
    {
        return $this->cookTime;
    }

    /**
     * @param int $cookTime
     */
    public function setCookTime($cookTime)
    {
        $this->cookTime = $cookTime;
    }

}