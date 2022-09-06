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
        $user->setEmail('a.milenkovic32124245@gmail.com');
        $password = $this->hasher->hashPassword($user, 'test123');
        $user->setPassword($password);
        $user->setName('Milenkovic3423434');
        $user->setFirstName('Aleksandar2424');
        $this->addReference('user', $user );
        $manager->persist($user);

        $user1 = new User();
        $user1->setRoles(['ROLE_TENANT']);
        $user1->setEmail('aleksandar.milenkovicfr2424@gmail.com');
        $password = $this->hasher->hashPassword($user1, 'test123');
        $user1->setPassword($password);
        $user1->setName('Dupont24242');
        $user1->setFirstName('Pierre24242');
        $this->addReference('user1', $user1 );
        $manager->persist($user1);

        $user2 = new User();
        $user2->setRoles(['ROLE_REPRESENTATIVE']);
        $user2->setEmail('aleksandar.milenkovic@lyceestvincent24244.fr');
        $password = $this->hasher->hashPassword($user2, 'test123');
        $user2->setPassword($password);
        $user2->setName('Messi242424');
        $user2->setFirstName('Lionel242442');
        $this->addReference('user2', $user2 );
        $manager->persist($user2);

        $manager->flush();
    }
}
