<?php
namespace CookWithMeBundle\Services;

use CookWithMeBundle\Entity\Ingredient;
use CookWithMeBundle\Entity\Recipe;
use CookWithMeBundle\Managers\RecipeManager;

class RecipeService {
    /**
     * @var RecipeManager
     */
    protected $recipeManager;

    /**
     * @var StepService
     */
    protected $stepService;

    /**
     * @var IngredientService
     */
    protected $ingredientService;
    /**
     * @param RecipeManager $recipeManager
     * @param StepService $stepService
     */
    public function __construct(RecipeManager $recipeManager, StepService $stepService, IngredientService $ingredientService) {
        $this->recipeManager = $recipeManager;
        $this->stepService = $stepService;
        $this->ingredientService = $ingredientService;
    }

    /**
     * Adds a new recipe.
     *
     * @param Array $recipeData
     * @param Array $ingredientData
     * @return Recipe
     */
    public function addRecipe($recipeData) {
        $recipeEntity = new Recipe();
        $recipeEntity->setTitle($recipeData['title']);
        $recipeEntity->setCookTime($recipeData['cookTime']);

        $this->recipeManager->addRecipe($recipeEntity);

        $this->addStepsToRecipe($recipeEntity, $recipeData['steps']);

        $this->addIngredientsToRecipe($recipeEntity, $recipeData['ingredients']);

        $this->recipeManager->saveChanges();

        return $recipeEntity;
    }

    /**
     * return Recipes with limit per page
     *
     * @param integer $page
     * @param integer $pageSize
     * @param string $title
     * @return array
     */
    public function getRecipes($page,$pageSize,$title){

        if($page < 1){
            $page = 1;
        }

        $start = ($page -1) *$pageSize;
        $end = $start + $pageSize;



        $recipes = $this->recipeManager->getRecipes($start,$end,$title);
        return $recipes;
    }

    /**
     * return Recipe by Id
     *
     * @param $id
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

    /**
     * @param Recipe $recipe
     * @param $stepsData
     */
    public function addStepsToRecipe(Recipe $recipe, $stepsData){
       $steps =  $this->stepService->createSteps($stepsData);
        foreach($steps as $step){
            $recipe->addStep($step);
        }
    }

    /**
     * @param Recipe $recipe
     * @param $ingredientsData
     */
    public function addIngredientsToRecipe(Recipe $recipe, $ingredientsData){
        $ingredients = $this->ingredientService->createIngredients($ingredientsData);
        foreach($ingredients as $ingredient){
            $recipe->addIngredient($ingredient);
        }
    }

}