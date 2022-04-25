<?php

namespace App\DataFixtures;

use App\Entity\Informations;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class InformationsFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $info = new Informations();
        $info->setAdresse('test');
        $info->setNumeroAppartement(1);
        $info->setBatiment('test');
        $info->setCodePostal(12345);
        $info->setEtage(1);
        $info->setVille('test');
        $info->setTelephone(1234567890);
        $info->setTenant($this->getReference('user'.rand(1, 2)));
        $this->addReference('info', $info);
        $manager->persist($info);

        $info1 = new Informations();
        $info1->setAdresse('test1');
        $info1->setNumeroAppartement(2);
        $info1->setBatiment('test1');
        $info1->setCodePostal(12345);
        $info1->setEtage(2);
        $info1->setVille('test1');
        $info1->setTelephone(1234567890);
        $info1->setTenant($this->getReference('user'.rand(1, 2)));
        $this->addReference('info', $info1);
        $manager->persist($info1);

        $info2 = new Informations();
        $info2->setAdresse('test2');
        $info2->setNumeroAppartement(3);
        $info2->setBatiment('test2');
        $info2->setCodePostal(12345);
        $info2->setEtage(3);
        $info2->setVille('test2');
        $info2->setTelephone(1234567890);
        $info2->setTenant($this->getReference('user'.rand(1, 2)));
        $this->addReference('info', $info2);
        $manager->persist($info2);

        $manager->flush();
    }
}
