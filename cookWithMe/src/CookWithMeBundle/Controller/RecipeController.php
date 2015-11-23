<?php

namespace CookWithMeBundle\Controller;

use CookWithMeBundle\Managers\RecipeManager;
use CookWithMeBundle\Models\RecipeModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class RecipeController extends Controller
{
    const SUCCESS = 1;
    const FAIL = 0;
    const PAGE_SIZE = 10;
    /**
     * @Route("/recipe/{page}", defaults={"page" = 1})]
     */
    public function indexAction(Request $request, $page)
    {
        $service = $this->get("recipe_service");

        $title = $request->request->get('title');
        $recipeEntities = $service->getRecipes($page, self::PAGE_SIZE, $title);
        $recipeModels = array();
        foreach ($recipeEntities as $recipe) {
            $model = new RecipeModel($recipe);
            $recipeModels[] = $model;
        }
        return new JsonResponse($recipeModels);
    }

    /**
     * @Route("/add" , name="addRecipe")
     * @Method({"POST"})
     */
    public function addAction(Request $request)
    {
        $recipeService = $this->get('recipe_service');
        $recipeData = [
            'title' => $request->request->get('title'),
            'cookTime' => $request->request->get('cookTime'),
        ];

        $recipeEntity = $recipeService->addRecipe($recipeData);
        $recipeModel = new RecipeModel($recipeEntity);

        return new JsonResponse($recipeModel);
    }

    /**
     * @Route("/recipe/{id}", name="getRecipeById")
     * @Method({"GET"})
     */
    public function getRecipeAction($id)
    {
        $recipeService = $this->get("recipe_service");

        $recipeEntity = $recipeService->getRecipeById($id);
        $recipeModel = new RecipeModel($recipeEntity);

        return new JsonResponse($recipeModel);
    }

    /**
     * @Route("/recipe/edit/{id}", name="updateRecipeById")
     * @Method({"PUT"})
     */
    public function updateRecipeById(Request $request, $id)
    {
        $recipeService = $this->get("recipe_service");

        $recipeEntity = $recipeService->getRecipeById($id);

        $recipeData = [
            'title' => $request->request->get('title'),
            'cookTime' => $request->request->get('cookTime'),
        ];
        $updatedRecipe = $recipeService->updateRecipe($recipeEntity, $recipeData);

        $recipeModel = new RecipeModel($updatedRecipe);
        return new JsonResponse($recipeModel);
    }

    /**
     * @Route("/recipe/delete/{id}", name="deleteRecipeById")
     * @Method("DELETE")
     */
    public function deleteRecipeById(Request $request, $id)
    {
        $recipeService = $this->get("recipe_service");

        $recipeEntity = $recipeService->getRecipeById($id);

        $result = self::FAIL;
        if ($recipeEntity) {
            $result = $recipeService->deleteRecipeById($recipeEntity);
        }

        $success = $result ? self::SUCCESS : self::FAIL;

        return new JsonResponse(["success" => $success]);

    }
}
