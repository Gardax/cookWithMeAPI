<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 11/23/15
 * Time: 9:21 PM
 */

namespace CookWithMeBundle\Models;

use CookWithMeBundle\Entity\Ingredient;

/**
 * Class IngredientModel
 * @package CookWithMeBundle\Models
 */
class IngredientModel
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @param Ingredient $ingredient
     */
    public function __construct(Ingredient $ingredient){

        $this->id = $ingredient->getId();
        $this->name = $ingredient->getName();
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

}