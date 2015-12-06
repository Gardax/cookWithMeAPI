<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 12/4/15
 * Time: 6:41 PM
 */

namespace CookWithMeBundle\Models;

use CookWithMeBundle\Entity\User;
class UserModel
{

    /**
     * @var array
     */
    public $roles = array();

    /**
     * @var
     */
    public $id;

    /**
     * @var
     */
    public $salt;

    /**
     * @var
     */
    public $username;

    /**
     * @var
     */
    public $password;

    /**
     * @var
     */
    public $email;

    /**
     * @var
     */
    public $isActive;

    public function __construct(User $user){

        $this->id = $user->getId();
        $this->username = $user->getUsername();
        $this->email = $user->getEmail();
        $this->password = $user->getPassword();
        $this->isActive = $user->getIsActive();
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
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
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param mixed $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param mixed $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }




}