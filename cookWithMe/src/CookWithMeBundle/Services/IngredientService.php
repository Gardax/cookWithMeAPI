<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 11/23/15
 * Time: 9:04 PM
 */

namespace CookWithMeBundle\Services;


use CookWithMeBundle\Entity\Ingredient;
use CookWithMeBundle\Managers\IngredientManager;

class IngredientService
{
    /**
     * @var
     */
    protected $ingredientManager;

    /**
     * @param IngredientManager $ingredientsManager
     */
    public function __construct(IngredientManager $ingredientsManager) {
        $this->ingredientManager = $ingredientsManager;
    }

    /**
     * @param $ingredientsData
     * @return array
     */
    public function createIngredients($ingredientsData){
        $ingredients = array();
        foreach($ingredientsData as $entityData){
            $ingredientEntity = new Ingredient();
            $ingredientEntity->setName($entityData['name']);
            $this->ingredientManager->persistStep($ingredientEntity);

            $ingredients[] = $ingredientEntity;
        }
        $this->ingredientManager->saveChanges();

        return $ingredients;
    }
}