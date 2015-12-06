<?php

namespace AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CookWithMeBundle\Entity\Role;
use CookWithMeBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class LoadUserData  implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $roleAdmin = new Role();
        $roleAdmin->setRole('ROLE_ADMIN');
        $manager->persist($roleAdmin);
        $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);

        $roleUser = new Role();
        $roleUser->setRole('ROLE_USER');
        $manager->persist($roleUser);


        $user = new User();
        $user->setUsername('admin');
        $user->setEmail('admin@g-mail.com');
        $user->setSalt(md5(time()));
        $password = $encoder->encodePassword(
            'Don`t want to tell you. ', $user->getSalt());
        $user->setPassword($password);
        $user->setRoles($roleAdmin);
        $user->setRoles($roleUser);
        $manager->persist($user);

        $manager->flush();
    }
}