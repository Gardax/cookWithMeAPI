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
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class UserService
 * @package CookWithMeBundle\Services
 */
class UserService implements UserProviderInterface
{
    const ROLE_USER = 'ROLE_USER';

    /**
     * @var UserManager
     */
    protected $userManager;

    /**
     * @var UserPasswordEncoderInterface
     */
    protected $passwordEncoder;

    /**
     * UserService constructor.
     * @param UserManager $userManager
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserManager $userManager, UserPasswordEncoderInterface $passwordEncoder) {
        $this->userManager = $userManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function addUser(User $user){
        $user->setSalt();
        $password = $this->passwordEncoder->encodePassword($user, $user->getPassword());
        $user->setPassword($password);

        $roleUser = $this->getUserRole();
        $user->addRole($roleUser);

        $user = $this->userManager->addUser($user);

        $this->setUserApiKey($user);

        return $user;
    }

    /**
     * Authenticates a user.
     *
     * @param string $userUniqueIdentifier      The username or the email of the user.
     * @param string $password                  Plain text password.
     * @return User
     */
    public function authenticateUser($userUniqueIdentifier, $password) {
        $user = $this->userManager->getUserByUserNameOrEmail($userUniqueIdentifier);

        if(!$user) {
            throw new Exception('There is no user with this email or username.');
        }

        if(!$this->passwordEncoder->isPasswordValid($user, $password)) {
            throw new Exception('Incorrect password.');
        }

        $user = $this->setUserApiKey($user);

        return $user;
    }

    public function setUserApiKey(User $user) {
        $apiKey = $this->generateApiKey($user);
        $user->setApiKey($apiKey);

        $this->userManager->saveChanges();

        return $user;
    }

    public function getUserById($id){
        $user = $this->userManager->getUserById($id);

        return $user;
    }

    public function getUsernameForApiKey($apiKey) {
        $user = $this->userManager->getUserByApiKey($apiKey);

        return $user->getUsername();
    }

    public function loadUserByUsername($username) {
        return $this->userManager->getUserByUsername($username);
    }

    /**
     * Returns ROLE_USER entity.
     *
     * @return \CookWithMeBundle\Entity\Role
     */
    protected function getUserRole() {
        return $this->userManager->getUserRole(self::ROLE_USER);
    }

    public function refreshUser(UserInterface $user)
    {
        // this is used for storing authentication in the session
        // but in this example, the token is sent in each request,
        // so authentication can be stateless. Throwing this exception
        // is proper to make things stateless
        throw new UnsupportedUserException();
    }

    public function supportsClass($class)
    {
        return 'CookWithMeBundle\Entity\User' === $class;
    }

    private function generateApiKey(User $user) {
        $apiKey = $user->getId();
        $apiKey .= uniqid(md5($user->getUsername() . time()));

        return $apiKey;
    }
}