<?php

namespace App\DataFixtures;

use App\Entity\Residence;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ResidenceFixtures extends Fixture 
{
    public function load(ObjectManager $manager): void
    {
            $residence = new Residence();
            $residence->setName('Residence1');
            $residence->setAddress('Adress1');
            $residence->setCity('Name1');
            $residence->setZipCode('Name');
            $residence->setCountry('It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum');
            $residence->setInventoryFile('It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum');
            $residence->setOwner($this->getReference('user'));
            $residence->setRepresentative($this->getReference('user2'));
            $residence->setPhoto('photo');
            $this->addReference('residence1', $residence );
            $manager->persist($residence);

        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
