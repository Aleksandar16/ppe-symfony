<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Residence;
use App\Entity\Rent;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ResidenceFixtures extends Fixture 
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $residence = new Residence();
            $residence->setName('Residence'.$i);
            $residence->setAdress('Adress'.$i);
            $residence->setCity('Name'.$i);
            $residence->setZipCode('Name');
            $residence->setCoutry('It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum');
            $residence->setInventoryFile('It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum');
            $residence->setOwnerId(rand(0,20));
            $residence->setRepresentativeId(rand(0,20));

            $manager->persist($residence);
        }
        
        $manager->flush();
    }
}
