<?php

namespace CookWithMeBundle\Controller;

use CookWithMeBundle\Entity\Recipe;
use CookWithMeBundle\Managers\RecipeManager;
use CookWithMeBundle\Models\RecipeModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RecipeController extends Controller
{
    const SUCCESS = 1;
    const FAIL = 0;
    const PAGE_SIZE = 10;
    const MIN_TITLE_LENGTH = 4;

    /**
     * @Route("/recipe/{page}", defaults={"page" = 1})]
     */
    public function indexAction(Request $request, $page)
    {
        try{
            if(!isset($page)){
                throw new \Exception("You must enter a number for indexer!");
            }
            if(!is_numeric($page)){
                throw new \Exception("The page indexer must be number!");
            }
            if($page < 1){
                throw new \Exception("The page indexer can be only positive number !");
            }

            $service = $this->get("recipe_service");

            $title = $request->query->get('title');
            $ingredientIds = $request->query->get('ingredientIds');
            $recipeEntities = $service->getRecipes($page, self::PAGE_SIZE, $title, $ingredientIds);
            $recipeModels = array();
            foreach ($recipeEntities as $recipe) {
                $model = new RecipeModel($recipe);
                $recipeModels[] = $model;

            }

            return new JsonResponse($recipeModels);
        }catch (\Exception $ex){
            return new JsonResponse([
                "error" => $ex->getMessage(),
                "success" => self::FAIL
            ]);
        }
    }

    /**
     * @Route("/add" , name="addRecipe")
     * @Method({"POST"})
     */
    public function addAction(Request $request)
    {
        $recipeService = $this->get('recipe_service');
        try{
            $recipeData = [
                'title' => $request->request->get('title'),
                'cookTime' => $request->request->get('cookTime'),
                'steps' => $request->request->get('steps'),
                'ingredients' => $request->request->get('ingredients'),
            ];
            /**
             * Error Handling for exceptions if some of the params for recipeData[] are missing
             */
            if(!isset($recipeData['title']) || is_null($recipeData['title'])){
                throw new \Exception("The recipe must have a title!Are you miss something ?");
            }
            if(!isset($recipeData['cookTime']) || is_null($recipeData['cookTime'])){
                throw new \Exception("The recipe must have a cookTime!Are you miss something ?");
            }
            if(!isset($recipeData['steps']) || is_null($recipeData['steps'])){
                throw new \Exception("The recipe must have steps!Are you miss something ?");
            }
            if(!isset($recipeData['ingredients']) || is_null($recipeData['ingredients'])){
                throw new \Exception("The recipe must have at least one ingredient!Are you miss something ?");
            }
            /**
             * Error handling for exceptions if some of the params passed to recipeData[] are wrong
             */

            if(isset($recipeData['title']) && is_numeric($recipeData['title'])){
                throw new \Exception("The recipe must have title described with letters only! Are you missing something?");
            }
            if(isset($recipeData['cookTime'])  && !is_string($recipeData['cookTime'])){
                throw new \Exception("The recipe cookTime must be described with numbers!Are you miss something ?");
            }
            if(isset($recipeData['steps'])  && is_numeric($recipeData['steps'])){
                throw new \Exception("The recipe must have steps described with letters!Are you miss something ?");
            }
            if(isset($recipeData['ingredients']) && is_numeric($recipeData['ingredients'])){

                throw new \Exception("The recipe must have ingredients described with letters!Are you miss something ?");
            }
            if(is_numeric($recipeData['steps'][0]['action'])){
                throw new \Exception("You can not assign a number for describing action for steps!");
            }

            if(is_numeric($recipeData['ingredients'][0]['name'])){
                throw new \Exception("You can not assign a number for a name of ingredient!");
            }

            $recipeEntity = $recipeService->addRecipe($recipeData);
            $recipeModel = new RecipeModel($recipeEntity);

            return new JsonResponse($recipeModel);

        }catch (\Exception $ex){
            return new JsonResponse([
                "error" => $ex->getMessage(),
                "success" => self::FAIL
            ]);
        }

    }

    /**
     * @Route("/recipe/single/{id}", name="getRecipeById")
     * @Method({"GET"})
     */
    public function getRecipeAction($id)
    {
        try{
            if(!$id || !is_numeric($id)){
                throw new \Exception("The identifier for the recipe must be a number! ");
            }elseif($id < 1){
                throw new \Exception("The recipe identificator can not be a negative number.");
            }

            $recipeService = $this->get("recipe_service");

            $recipeEntity = $recipeService->getRecipeById($id);
            if(!$recipeEntity){
                throw new Exception("Recipe not found.");
            }
            $recipeModel = new RecipeModel($recipeEntity);

            return new JsonResponse($recipeModel);
        }catch (\Exception $ex){
            return new JsonResponse([
                "error" => $ex->getMessage(),
                "success" => self::FAIL
            ]);
        }

    }

    /**
     * @Route("/recipe/edit/{id}", name="updateRecipeById")
     * @Method({"PUT"})
     */
    public function updateRecipeById(Request $request, $id)
    {
        try{
            if(!$id || !is_numeric($id)){
                throw new \Exception("The identifier for the recipe must be a number! ");
            }elseif($id < 1){
                throw new \Exception("The recipe identificator can not be a negative number.");
            }

            $recipeService = $this->get("recipe_service");

            $recipeEntity = $recipeService->getRecipeById($id);

            $recipeData = [
                'title' => $request->request->get('title'),
                'cookTime' => $request->request->get('cookTime'),
            ];

            /**
             * error handling for a non existing values of variables and setting wrong type of data to the variables
             */
            if(!isset($recipeData['title']) || count($recipeData['title']) < self::MIN_TITLE_LENGTH ){
                throw new \Exception("The recipe must have a title!Are you miss something ?");
            }
            if(!isset($recipeData['cookTime']) || !$recipeData['cookTime']){
                throw new \Exception("The recipe must have a cookTime!Are you miss something ?");
            }
            if(isset($recipeData['title']) && is_numeric($recipeData['title'])){
                throw new \Exception("The recipe must have title described with letters only!");
            }
            if(isset($recipeData['cookTime'])  && is_string($recipeData['cookTime'])){
                throw new \Exception("The recipe cookTime must be described with numbers!");
            }
            /**
             * end of error handling
             */

            $updatedRecipe = $recipeService->updateRecipe($recipeEntity, $recipeData);

            $recipeModel = new RecipeModel($updatedRecipe);
            return new JsonResponse($recipeModel);
        }catch (\Exception $ex){
            return new JsonResponse([
                "error" => $ex->getMessage(),
                "success" => self::FAIL
            ]);
        }

    }

    /**
     * @Route("/recipe/delete/{id}", name="deleteRecipeById")
     * @Method("DELETE")
     */
    public function deleteRecipeById(Request $request, $id)
    {
        try {
            if(!$id || !is_numeric($id)){
                throw new \Exception("The identifier for the recipe must be a number! ");
            }elseif($id < 1){
                throw new \Exception("The recipe identificator can not be a negative number.");
            }

            $recipeService = $this->get("recipe_service");

            $recipeEntity = $recipeService->getRecipeById($id);

            $result = self::FAIL;
            if ($recipeEntity) {
                $result = $recipeService->deleteRecipeById($recipeEntity);
            }

            $success = $result ? self::SUCCESS : self::FAIL;

            return new JsonResponse(["success" => $success]);
            }catch (\Exception $ex){
            return new JsonResponse([
                "error" => $ex->getMessage(),
                "success" => self::FAIL
            ]);
        }
    }
}
