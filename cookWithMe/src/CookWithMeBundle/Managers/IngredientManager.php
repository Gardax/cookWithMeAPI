<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 11/23/15
 * Time: 9:04 PM
 */

namespace CookWithMeBundle\Managers;

use CookWithMeBundle\Entity\Ingredient;
use Doctrine\ORM\EntityManager;

/**
 * Class IngredientManager
 * @package CookWithMeBundle\Managers
 */
class IngredientManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em) {
        $this->entityManager=$em;
    }

    /**
     * @param Ingredient $ingredient
     */
    public function persistStep(Ingredient $ingredient){
        $this->entityManager->persist($ingredient);
    }

    public function saveChanges(){
        $this->entityManager->flush();
    }
}