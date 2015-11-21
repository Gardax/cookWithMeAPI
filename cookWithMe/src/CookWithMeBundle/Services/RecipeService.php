<?php
namespace CookWithMeBundle\Services;

use CookWithMeBundle\Entity\Recipe;
use CookWithMeBundle\Managers\RecipeManager;

class RecipeService {
    /**
     * @var EntityManager
     */
    protected $recipeManager;
    public function __construct(RecipeManager $recipeManager) {
        $this->recipeManager = $recipeManager;
    }

    public function addRecipe($recipeData) {
        $recipeEntity = new Recipe();
        $recipeEntity->setTitle($recipeData['title']);
        $recipeEntity->setCookTime($recipeData['cookTime']);

        return $this->recipeManager->addRecipe($recipeEntity);
    }
}