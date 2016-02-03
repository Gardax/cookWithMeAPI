<?php

namespace CookWithMeBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CookWithMeBundle\Entity\Role;
use CookWithMeBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    /**
    * @var ContainerInterface
    */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setEmail('admin@test.com');

        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user, 'faster');
        $user->setPassword($password);
        $manager->persist($user);
        $manager->flush();

        $roleAdmin = new Role();
        $roleAdmin->setRole('ROLE_ADMIN');
        $roleAdmin->addUser($user);
        $manager->persist($roleAdmin);

        $roleUser = new Role();
        $roleUser->setRole('ROLE_USER');
        $roleUser->addUser($user);
        $manager->persist($roleUser);

        $user->addRole($roleAdmin);
        $user->addRole($roleUser);

        $manager->flush();
    }
}