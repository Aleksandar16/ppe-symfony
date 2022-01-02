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
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setRole('role');
            $user->setEmail('email'.rand(0,20).'@gmail.com');
            $password = $this->hasher->hashPassword($user, 'pass_1234');
            $user->setPassword($password);
            $this->addReference('user'.$i, $user );
            $manager->persist($user);
        }
        $manager->flush();
    }
}
