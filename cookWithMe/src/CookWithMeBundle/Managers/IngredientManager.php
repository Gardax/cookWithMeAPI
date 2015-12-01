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

    /**
     * @param $names
     * @return array
     */
    public function getIngredientsByName($names){

        $query = $this->entityManager->createQuery('SELECT i FROM CookWithMeBundle:Ingredient i WHERE i.name IN (:names)');
        $query->setParameters(array(
            'names'=>$names
        ));
        $ingredients = $query->getResult();
        return $ingredients;
    }
}