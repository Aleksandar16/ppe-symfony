<?php

namespace App\DataFixtures;

use App\Entity\Residence;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ResidenceFixtures extends Fixture 
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $residence = new Residence();
            $residence->setName('Residence'.$i);
            $residence->setAddress('Adress'.$i);
            $residence->setCity('Name'.$i);
            $residence->setZipCode('Name');
            $residence->setCountry('It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum');
            $residence->setInventoryFile('It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum');
            $residence->setOwner($this->getReference('user'.rand(1, 19)));
            $residence->setRepresentative($this->getReference('user'.rand(1, 19)));
            $this->addReference('residence'.$i, $residence );
            $manager->persist($residence);
        }

        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
