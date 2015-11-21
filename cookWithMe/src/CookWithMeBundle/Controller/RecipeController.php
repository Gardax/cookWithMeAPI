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
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        
        return array();
    }

    /**
     * @Route("/add" , name="addRecipe")
     * @Method({"POST"})
     */
    public function addAction(Request $request)
    {
        $recipeService = $this->get('recipe_service');
        $recipe = [
            'title' => $request->request->get('title'),
            'cookTime' => $request->request->get('cookTime'),
        ];

        $recipeResult = $recipeService->addRecipe($recipe);
        $recipeModel = new RecipeModel($recipeResult);

        return new JsonResponse($recipeModel);
    }
}
