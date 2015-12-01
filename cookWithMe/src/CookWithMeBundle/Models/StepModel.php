<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 11/22/15
 * Time: 4:02 PM
 */

namespace CookWithMeBundle\Models;


use CookWithMeBundle\Entity\Step;

/**
 * Class StepModel
 * @package CookWithMeBundle\Models
 */
class StepModel
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $action;

    /**
     * @var int
     */
    public $estimatedTime;


    /**
     * @param Step $step
     */
    function __construct(Step $step)
    {
        $this->id = $step->getId();
        $this->action = $step->getAction();
        $this->estimatedTime = $step->getEstimatedTime();;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return int
     */
    public function getEstimatedTime()
    {
        return $this->estimatedTime;
    }

    /**
     * @param int $estimatedTime
     */
    public function setEstimatedTime($estimatedTime)
    {
        $this->estimatedTime = $estimatedTime;
    }

}