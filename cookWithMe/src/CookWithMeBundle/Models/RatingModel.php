<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 12/2/15
 * Time: 2:44 PM
 */

namespace CookWithMeBundle\Models;

use CookWithMeBundle\Entity\Rating;

/**
 * Class RatingModel
 * @package CookWithMeBundle\Models
 */
class RatingModel
{
    /**
     * @var
     */
    public $id;

    /**
     * @var
     */
    public $score;

    /**
     * @var
     */
    public $comment;

    /**
     * @param Rating $rating
     */
    public function __construct(Rating $rating){

        $this->id = $rating->getId();
        $this->score = $rating->getScore();
        $this->comment = $rating->getComment();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param mixed $score
     */
    public function setScore($score)
    {
        $this->score = $score;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }



}