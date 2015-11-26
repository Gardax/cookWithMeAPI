<?php

namespace CookWithMeBundle\Managers;


use CookWithMeBundle\Entity\Recipe;
use Doctrine\ORM\EntityManager;

class RecipeManager {
    /**
     * @var EntityManager
     */
    private $entityManager;
    public function __construct(EntityManager $em) {
        $this->entityManager=$em;
    }

    /**
     * return Recipes selected by ingredient
     *
     * @param integer $start
     * @param integer $end
     * @param  string $recipeIngredients
     * @return array
     */

    public function getRecipeByIngredient($start,$end,$recipeIngredients){
        $em = $this->entityManager;
        $query = $em->createQuery(
            "SELECT r, i
            FROM CookWithMeBundle:Recipe r
            JOIN r.ingredients i
            WHERE r. LIKE :title"
        )->setParameters([
            "recipe_ingredient" => $recipeIngredients
        ])
            ->setFirstResult($start)
            ->setMaxResults($end);

        $recipes = $query->getResult();
        return $recipes;
    }

    /**
     * Adds a recipe.
     *
     * @param Recipe $recipeEntity
     * @return Recipe
     */
    public function addRecipe(Recipe $recipeEntity) {
        $this->entityManager->persist($recipeEntity);
        $this->entityManager->flush();

        return $recipeEntity;
    }

    /**
     * @param integer $start
     * @param integer $end
     * @param null $title
     * @param array $ingredientIds
     * @return array
     */
    public function getRecipes($start,$end,$title = null, $ingredientIds = []){

        $em = $this->entityManager;

        $parameters = [];

        $queryString = "SELECT r
                  FROM CookWithMeBundle:Recipe r";

        //if($ingredientIds) {
//            $queryString .= " JOIN r.ingredients i";
       // }
        $queryString .= " WHERE 1=1 ";

        if($title) {
            $queryString .= " AND r.title LIKE :title";
            $parameters['title'] = "%" . $title . "%";
        }

//        if($ingredientIds) {
//            $queryString .= " AND i.id IN (:ingIds)";
//            $parameters['ingIds'] = $ingredientIds;
//        }

//        if($ingredientIds) {
//            $queryString .= " AND i.id IN (:ingIds) Group by r.id";
//            $parameters['ingIds'] = $ingredientIds;
//        }

        $query = $em->createQuery($queryString)
                    ->setParameters($parameters)
                    ->setFirstResult($start)
                    ->setMaxResults($end);

        //echo $query->getSQL();

        $recipes = $query->getResult();
        return $recipes;
    }


    /**
     * Gets a recipe by id.
     *
     * @param $id
     * @return Recipe|null
     */
    public function getRecipeById($id)
    {
        $recipe = $this->entityManager->getRepository("CookWithMeBundle:Recipe")->find($id);

        return $recipe;
    }

    /**
     * Flushes all entities.
     */
    public function saveChanges(){
        $this->entityManager->flush();
    }

    /**
     * Delete recipe by id.
     *
     * @param $id
     * @return bool
     */
    public function deleteRecipeById($id){
        $this->entityManager->remove($id);
        $this->entityManager->flush();

        return true;
    }

}