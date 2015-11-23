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
     * get Recipes by title if passed/ not passed
     *
     * @param integer $start
     * @param integer $end
     * @param string $title
     * @return array
     */
    public function getRecipes($start,$end,$title){


        if($title == null){
            $em = $this->entityManager;
            $query = $em->createQuery(
                "SELECT r
            FROM CookWithMeBundle:Recipe r
            "
            )   ->setFirstResult($start)
                ->setMaxResults($end);

            $recipes = $query->getResult();
            return $recipes;
        }else{
            $em = $this->entityManager;
            $query = $em->createQuery(
                "SELECT r
            FROM CookWithMeBundle:Recipe r
            WHERE r.title LIKE :title"
            )->setParameters([
                "title" => $title
            ])
                ->setFirstResult($start)
                ->setMaxResults($end);

            $recipes = $query->getResult();
            return $recipes;
        }




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