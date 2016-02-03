<?php

namespace CookWithMeBundle\Controller;

use CookWithMeBundle\Entity\Recipe;
use CookWithMeBundle\Managers\RecipeManager;
use CookWithMeBundle\Models\RecipeModel;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class RecipeController
 * @package CookWithMeBundle\Controller
 */
class RecipeController extends FOSRestController
{
    const SUCCESS = 1;
    const FAIL = 0;
    const PAGE_SIZE = 10;

    /**
     * @Route("/recipe/{page}", defaults={"page" = 1})
     * @Security("has_role('ROLE_USER')")
     * @Method({"GET"})
     * @param Request $request
     * @param $page
     * @return JsonResponse
     */
    public function indexAction(Request $request, $page)
    {
//        if(!$this->getUser()) {
//            return new JsonResponse([
//                "error" => "Fuck",
//                "success" => self::FAIL
//            ]);
//        }

        try{
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
     * @param Request $request
     * @return JsonResponse
     */
    public function addAction(Request $request)
    {
        $recipeService = $this->get('recipe_service');

        try{
            $recipeData = [
                'title' => $request->request->get('title'),
                'steps' => $request->request->get('steps'),
                'ingredients' => $request->request->get('ingredients'),
            ];

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

            $recipeService = $this->get("recipe_service");

            $recipeEntity = $recipeService->getRecipeById($id);

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
            $recipeService = $this->get("recipe_service");

            $recipeEntity = $recipeService->getRecipeById($id);

            $recipeData = [
                'title' => $request->request->get('title'),
                'steps' => $request->request->get('steps'),
                'ingredients' => $request->request->get('ingredients')
            ];

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
            $recipeService = $this->get("recipe_service");

            $recipeEntity = $recipeService->getRecipeById($id);

            $result = self::FAIL;
            if ($recipeEntity) {
                $result = $recipeService->deleteRecipeById($recipeEntity);
            }

            $success = $result ? self::SUCCESS : self::FAIL;

            return new JsonResponse(["success" => $success]);
        } catch (\Exception $ex) {
            return new JsonResponse([
                "error" => $ex->getMessage(),
                "success" => self::FAIL
            ]);
        }
    }

    /**
     * @Route("/recipe/rate/{id}", name="rateRecipe")
     * @Method("POST")
     */
    public function rateRecipe(Request $request, $id){

    }


}
