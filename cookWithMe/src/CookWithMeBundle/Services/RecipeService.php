<?php
namespace CookWithMeBundle\Services;

use CookWithMeBundle\Entity\Recipe;
use CookWithMeBundle\Managers\RecipeManager;

class RecipeService {
    /**
     * @var RecipeManager
     */
    protected $recipeManager;

    /**
     * @param RecipeManager $recipeManager
     */
    public function __construct(RecipeManager $recipeManager) {
        $this->recipeManager = $recipeManager;
    }

    /**
     * Adds a new recipe.
     *
     * @param Array $recipeData
     * @return Recipe
     */
    public function addRecipe($recipeData) {
        $recipeEntity = new Recipe();
        $recipeEntity->setTitle($recipeData['title']);
        $recipeEntity->setCookTime($recipeData['cookTime']);

        return $this->recipeManager->addRecipe($recipeEntity);
    }

    /**
     * Gets all recipes.
     *
     * @return Recipe[]
     */
    public function getRecipes(){
        $recipes = $this->recipeManager->getRecipes();

        return $recipes;
    }

    /**
     * Gets recipe by id.
     *
     * @param integer $id
     * @return Recipe|null
     */
    public function getRecipeById($id){
        $recipe = $this->recipeManager->getRecipeById($id);

        return $recipe;
    }

    /**
     * Updates recipe.
     *
     * @param Recipe $recipe
     * @param $recipeData
     * @return Recipe
     */
    public function updateRecipe(Recipe $recipe,$recipeData){
        if(isset($recipeData['title'])){
            $recipe->setTitle($recipeData['title']);
        }
        if(isset($recipeData['cookTime'])){
            $recipe->setCookTime($recipeData['cookTime']);
        }
        $this->recipeManager->saveChanges();

        return $recipe;
    }

    /**
     * Deletes recipe.
     *
     * @param $id
     * @return boolean
     */
    public function deleteRecipeById($id){
        $result = $this->recipeManager->deleteRecipeById($id);

        return $result;
    }
}