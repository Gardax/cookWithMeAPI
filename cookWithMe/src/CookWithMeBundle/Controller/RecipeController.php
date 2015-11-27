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
            if(!$recipeEntities){
                throw new \Exception("There is not result!");
            }
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
            if(count($recipeData['ingredients']) < 1){
                throw new \Exception("The recipe must have at least 1 ingredient!");
            }
            if(count($recipeData['steps']) < 1){
                throw new \Exception("The recipe must have at least 1 step! ");
            }
            if(!isset($recipeData['title']) || !is_string($recipeData['title'])){
                throw new \Exception("There is a problem with the recipe title ?");
            }
            if(!isset($recipeData['cookTime'])){
                throw new \Exception("The recipe must have a cookTime!Are you miss something ?");
            }
            if(!isset($recipeData['steps'])){
                throw new \Exception("The recipe must have steps!Are you miss something ?");
            }
            if(!isset($recipeData['ingredients'])){
                throw new \Exception("The recipe must have at least one ingredient!Are you miss something ?");
            }
            /**
             * Error handling for exceptions if some of the params passed to recipeData[] are wrong
             */

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
            $id = $this->validateId($id);

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

            $id = $this->validateId($id);

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
            if(!isset($recipeData['cookTime']) || !is_numeric($recipeData['cookTime'])){
                throw new \Exception("The recipe must have a cookTime!Are you miss something ?");
            }

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
            $id = $this->validateId($id);

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

    public function validateId($id){
        if(!$id || !is_numeric($id)){
            throw new \Exception("The identifier for the recipe must be a number! ");
        }elseif($id < 1){
            throw new \Exception("The recipe identificator can not be a negative number.");
        }

        return $id;
    }
}
