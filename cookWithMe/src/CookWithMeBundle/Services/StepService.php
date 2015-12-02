<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 11/22/15
 * Time: 4:06 PM
 */

namespace CookWithMeBundle\Services;

use CookWithMeBundle\Entity\Step;
use CookWithMeBundle\Managers\StepManager;


/**
 * Class StepService
 * @package CookWithMeBundle\Services
 */
class StepService
{
    /**
     * @var StepManager
     */
    protected $stepManager;

    /**
     * @param StepManager $stepManager
     */
    public function __construct(StepManager $stepManager) {
        $this->stepManager = $stepManager;
    }

    /**
     * @param $stepsData
     * @return Step[]
     */
    public function createSteps($stepsData){
        $steps = array();
        foreach($stepsData as $entityData){
            if($entityData['action']) {
                $stepEntity = new Step();
                $stepEntity->setAction($entityData['action']);
                $stepEntity->setEstimatedTime($entityData['estimatedTime']);
                $this->stepManager->persistStep($stepEntity);

                $steps[] = $stepEntity;
            }
        }
        $this->stepManager->saveChanges();

        return $steps;
    }

    /**
     * @param $step
     */
    public function removeStep($step){
        $this->stepManager->removeStep($step);
    }
}