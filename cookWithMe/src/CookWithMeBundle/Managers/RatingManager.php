<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 12/2/15
 * Time: 2:35 PM
 */

namespace CookWithMeBundle\Managers;

use CookWithMeBundle\Entity\Rating;
use Doctrine\ORM\EntityManager;

class RatingManager
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
}