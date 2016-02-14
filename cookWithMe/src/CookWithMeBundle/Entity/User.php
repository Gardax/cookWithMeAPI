<?php

namespace CookWithMeBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */

class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    protected $salt;
    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank(groups={"registration", "login"}, message="Username cannot be blank.")
     * @Assert\Length(
     *     min=3,
     *     max=25,
     *     minMessage="Username should be between 3 and 25 characters.",
     *     maxMessage="Username should be between 3 and 25 characters.",
     *     groups={"registration"}
     * )
     */
    protected $username;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank(groups={"login", "register"}, message="Password cannot be blank.")
     * @Assert\Length(min=4, max = 100, groups={"registration"})
     */
    protected $password;


    /**
     * @ORM\Column(type="string", length=60, unique=true, nullable=true)
     * @Assert\Email(groups={"registration"}, message="Invalid email address.")
     */
    protected $email;

    /**
     * @ORM\Column(type="string", unique=true, nullable=true )
     */
    private $apiKey;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    protected $isActive = 1;

    /**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users")
     * @ORM\JoinTable(name="users_roles")
     */
    protected $roles = array();


    public function __construct()
    {
        $this->roles = new ArrayCollection();
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
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
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

    /**
     * @return array
     */
    public function getSalt()
    {
        return $this->salt;
    }


    public function setSalt() {
        $this->salt = $this->generateSalt();
    }

    /**
     * @return ArrayCollection
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param string $roles
     */
    public function setRoles($roles)
    {
        $this->roles[] = $roles;
    }

    public function addRole($role)
    {
        //if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
       // }
        return $this;
    }


    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
        ));
    }

    /**
     * @param string $serialized
     */
    public function unSerialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            ) = unserialize($serialized);
    }

    /**
     * @return array
     */
    private function generateSalt(){
        $generatedSalt = uniqid($this->getUsername());

        return $generatedSalt;
    }
}