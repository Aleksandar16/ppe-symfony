<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setRoles(['ROLE_OWNER']);
        $user->setEmail('a.milenkovic321@gmail.com');
        $password = $this->hasher->hashPassword($user, 'test123');
        $user->setPassword($password);
        $this->addReference('user', $user );
        $manager->persist($user);

        $user1 = new User();
        $user1->setRoles(['ROLE_TENANT']);
        $user1->setEmail('email'.rand(0,20).'@gmail.com');
        $password = $this->hasher->hashPassword($user1, 'pass_1234');
        $user1->setPassword($password);
        $this->addReference('user1', $user1 );
        $manager->persist($user1);

        $user2 = new User();
        $user2->setRoles(['ROLE_REPRESENTATIVE']);
        $user2->setEmail('email'.rand(0,20).'@gmail.com');
        $password = $this->hasher->hashPassword($user2, 'pass_1234');
        $user2->setPassword($password);
        $this->addReference('user2', $user2 );
        $manager->persist($user2);

        $manager->flush();
    }
}
