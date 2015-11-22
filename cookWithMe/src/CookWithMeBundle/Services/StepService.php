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
    public function createSteps($stepsData){

        foreach($stepsData as $step){
            $stepEntity = new Step();
            $stepEntity->setAction($step['action']);
            $stepEntity->setEstimatedTime($step['estimatedTime']);
            $this->stepManager->persistStep($stepEntity);
        }
        $this->stepManager->saveChanges();
    }
}