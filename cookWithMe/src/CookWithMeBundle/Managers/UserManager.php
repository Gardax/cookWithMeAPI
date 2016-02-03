<?php
/**
 * Created by PhpStorm.
 * User: suxorr
 * Date: 12/2/15
 * Time: 7:51 PM
 */

namespace CookWithMeBundle\Managers;

use CookWithMeBundle\Entity\User;
use Doctrine\ORM\EntityManager;

/**
 * Class UserManager
 * @package CookWithMeBundle\Managers
 */
class UserManager
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
     * @param User $userEntity
     * @return User
     */
    public function addUser(User $userEntity){
        $this->entityManager->persist($userEntity);
        $this->entityManager->flush();

        return $userEntity;
    }


    public function getUserById($id)
    {
        $user = $this->entityManager->getRepository("CookWithMeBundle:User")->find($id);

        return $user;
    }

    /**
     * @param $apiKey
     * @return User
     */
    public function getUserByApiKey($apiKey)
    {
        $query = $this->entityManager->createQuery(
            "SELECT u
             FROM CookWithMeBundle:User u
             WHERE u.apiKey LIKE :apikey"
        )
        ->setParameters([
            "apikey" => $apiKey
        ]);


        $user = $query->getOneOrNullResult();

        return $user;
    }

    /**
     * @param $username
     * @return User
     */
    public function getUserByUsername($username)
    {
        $query = $this->entityManager->createQuery(
            "SELECT u
             FROM CookWithMeBundle:User u
             WHERE u.username LIKE :username"
        )
            ->setParameters([
                "username" => $username
            ]);

        $user = $query->getOneOrNullResult();

        return $user;
    }

    /**
     * Flushes all entities.
     */
    public function saveChanges(){
        $this->entityManager->flush();
    }
}