<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 12/2/15
 * Time: 2:43 PM
 */

namespace CookWithMeBundle\Services;

use CookWithMeBundle\Entity\Rating;
use CookWithMeBundle\Managers\RatingManager;

/**
 * Class RatingService
 * @package CookWithMeBundle\Services
 */
class RatingService
{
    /**
     * @var RatingManager
     */
    protected $ratingManager;

    /**
     * @param RatingManager $ratingManager
     */
    public function __construct(RatingManager $ratingManager) {
        $this->ratingManager = $ratingManager;
    }
}