<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 11/22/15
 * Time: 5:03 PM
 */

namespace CookWithMeBundle\Managers;

use CookWithMeBundle\Entity\Step;
use Doctrine\ORM\EntityManager;

class StepManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $em) {
        $this->entityManager=$em;
    }
    public function persistStep(Step $step){
        $this->entityManager->persist($step);
    }
    public function saveChanges(){
        $this->entityManager->flush();
    }
}