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

    public function addRecipe(Recipe $recipeEntity) {
        $this->entityManager->persist($recipeEntity);
        $this->entityManager->flush();

        return $recipeEntity;
    }
}