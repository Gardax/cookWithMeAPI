<?php
namespace CookWithMeBundle\Services;

use CookWithMeBundle\Entity\Ingredient;
use CookWithMeBundle\Entity\Recipe;
use CookWithMeBundle\Managers\RecipeManager;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class RecipeService
 * @package CookWithMeBundle\Services
 */
class RecipeService {
    /**
     * @var int
     */
    const MIN_TITLE_LENGTH = 4;

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
     * @param IngredientService $ingredientService
     */
    public function __construct(RecipeManager $recipeManager, StepService $stepService, IngredientService $ingredientService) {
        $this->recipeManager = $recipeManager;
        $this->stepService = $stepService;
        $this->ingredientService = $ingredientService;
    }

    /**
     * Adds recipe
     *
     * @param Array $recipeData
     * @return Recipe
     * @throws \Exception
     */
    public function addRecipe($recipeData) {

        if(count($recipeData['ingredients']) < 1){
            throw new \Exception("The recipe must have at least 1 ingredient!");
        }
        if(count($recipeData['steps']) < 1){
            throw new \Exception("The recipe must have at least 1 step! ");
        }
        if(!isset($recipeData['title']) || !is_string($recipeData['title'])){
            throw new \Exception("There is a problem with the recipe title ?");
        }
        if(!isset($recipeData['steps'])){
            throw new \Exception("The recipe must have steps!Are you miss something ?");
        }
        if(!isset($recipeData['ingredients'])){
            throw new \Exception("The recipe must have at least one ingredient!Are you miss something ?");
        }

        $recipeEntity = new Recipe();
        $recipeEntity->setTitle($recipeData['title']);

        $this->recipeManager->addRecipe($recipeEntity);

        $this->addStepsToRecipe($recipeEntity, $recipeData['steps']);

        $this->addIngredientsToRecipe($recipeEntity, $recipeData['ingredients']);

        $this->recipeManager->saveChanges();

        return $recipeEntity;
    }

    /**
     * Gets Recipes with limit per page
     *
     * @param $page
     * @param $pageSize
     * @param null $title
     * @param array $ingredientIds
     * @return array
     * @throws \Exception
     */

    public function getRecipes($page,$pageSize,$title = null, $ingredientIds = []){

        if(!isset($page)){
            throw new \Exception("You must enter a number for indexer!");
        }
        if(!is_numeric($page)){
            throw new \Exception("The page indexer must be number!");
        }
        if($page < 1){
            throw new \Exception("The page indexer can be only positive number !");
        }
        
        $start = ($page -1) *$pageSize;
        $end = $start + $pageSize;

        $recipes = $this->recipeManager->getRecipes($start,$end,$title, $ingredientIds);
        if(!$recipes){
            throw new \Exception("There is not result!");
        }
        return $recipes;
    }

    /**
     * Gets Recipe by Id
     *
     * @param $id
     * @return Recipe|null
     */
    public function getRecipeById($id){

        $id = $this->validateId($id);

        $recipe = $this->recipeManager->getRecipeById($id);
        if(!$recipe){
            throw new Exception("Recipe not found.");
        }
        return $recipe;
    }

    /**
     * Updates recipe.
     *
     * @param Recipe $recipe
     * @param $recipeData
     * @return Recipe
     * @throws \Exception
     */

    public function updateRecipe(Recipe $recipe,$recipeData){
//        if(!isset($recipeData['title']) || count($recipeData['title']) < self::MIN_TITLE_LENGTH ){
//            throw new \Exception("The recipe must have a title!Are you miss something ?");
//        }

        if(isset($recipeData['title'])){
            $recipe->setTitle($recipeData['title']);
        }


        if(isset($recipeData['steps'])){
            $recipe->setSteps(array());
            $this->addStepsToRecipe($recipe,$recipeData['steps']);
        }
        if(isset($recipeData['ingredients'])){
            $recipe->setIngredients(array());
            $this->addIngredientsToRecipe($recipe,$recipeData['ingredients']);
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
        $id = $this->validateId($id);
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
            $step->setRecipe($recipe);
        }
    }

    /**
     * @param Recipe $recipe
     * @param $ingredientsData
     */
    public function addIngredientsToRecipe(Recipe $recipe, $ingredientsData){

        $names = array();
        foreach($ingredientsData as $ingredient){
            $names[]=$ingredient['name'];
        }

        $missingIngredients = array();
        $ingredientEntity = $this->ingredientService->getIngredient($names);

        foreach($ingredientsData as $ingredient){
            $found = false;
            for($i = 0; $i < count($ingredientEntity); $i++){
                if($ingredient['name'] == $ingredientEntity[$i]->getName()) {
                    $found = true;
                }
            }
            if(!$found) {
                array_push($missingIngredients, $ingredient);
            }
        }

        $ingredients = $this->ingredientService->createIngredients($missingIngredients);
        $ingredients = array_merge($ingredients, $ingredientEntity);
        foreach($ingredients as $ingredient){
            $recipe->addIngredient($ingredient);
        }
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function validateId($id){
        if(!$id || !is_numeric($id)){
            throw new \Exception("The identifier for the recipe must be a number! ");
        }elseif($id < 1){
            throw new \Exception("The recipe identificator can not be a negative number.");
        }

        return $id;
    }

}