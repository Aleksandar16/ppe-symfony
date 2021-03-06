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
        $user->setName('Milenkovic');
        $user->setFirstName('Aleksandar');
        $this->addReference('user', $user );
        $manager->persist($user);

        $user1 = new User();
        $user1->setRoles(['ROLE_TENANT']);
        $user1->setEmail('email1@gmail.com');
        $password = $this->hasher->hashPassword($user1, 'test1234');
        $user1->setPassword($password);
        $user1->setName('Dupont');
        $user1->setFirstName('Pierre');
        $this->addReference('user1', $user1 );
        $manager->persist($user1);

        $user2 = new User();
        $user2->setRoles(['ROLE_REPRESENTATIVE']);
        $user2->setEmail('email2@gmail.com');
        $password = $this->hasher->hashPassword($user2, 'test12345');
        $user2->setPassword($password);
        $user2->setName('Messi');
        $user2->setFirstName('Lionel');
        $this->addReference('user2', $user2 );
        $manager->persist($user2);

        $manager->flush();
    }
}
