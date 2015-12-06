<?php
/**
 * Created by PhpStorm.
 * User: suxorr
 * Date: 12/2/15
 * Time: 7:51 PM
 */

namespace CookWithMeBundle\Services;


use CookWithMeBundle\Managers\UserManager;
use CookWithMeBundle\Entity\User;


/**
 * Class UserService
 * @package CookWithMeBundle\Services
 */
class UserService
{

    /**
     * @var UserManager
     */
    protected $userManager;

    /**
     * @param UserManager $userManager
     */
    public function __construct(UserManager $userManager) {
        $this->userManager = $userManager;
    }

    public function addUser($userData){

        if(count($userData['username']) < 3){
            throw new \Exception("The username must be more then 3 symbols.");
        }
        if(count($userData['email']) < 5){
            throw new \Exception("There is a problem with your e-mail. Please try again.");
        }
        if(count($userData['password']) < 5){
            throw new \Exception("The password must be more then 5 symbols.");
        }
        if(!isset($userData['username']) || !isset($userData['email']) || !isset($userData['password'])){
            throw new \Exception("Please enter your username.");
        }

        $userEntity = new User();
        $userEntity->setUsername($userData['username']);
        $userEntity->setEmail($userData['email']);
        $userEntity->setPassword($userData['password']);

        $this->userManager->addUser($userEntity);

        $this->userManager->saveChanges();

        return $userEntity;
    }
}