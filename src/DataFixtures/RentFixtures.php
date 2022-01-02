<?php

namespace App\DataFixtures;


use App\Entity\Rent;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class RentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        //Date atélatoire
        $timestamp = mt_rand(1, time());
        $date = new \DateTime ();
        $date->setTimestamp($timestamp);

        for ($i = 0; $i < 20; $i++) {
            $rent = new Rent();
            $rent->setTenant($this->getReference('user'.rand(1, 19)));
            $rent->setResidence($this->getReference('residence'.rand(1, 19)));
            $rent->setInventoryFile('file'.rand(0,20).'.pdf');
            $rent->setDepartureDate($date);
            $rent->setArrivalDate($date);
            $rent->setTenantComments('It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum');
            $rent->setTenantSignature('It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum');
            $rent->setTenantValidatedAt('It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum');
            $rent->setRepresentativeComments('It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum');
            $rent->setRepresentativeSignature('It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum');
            $rent->setRepresentativeValidatedAt($date);
            $this->addReference('rent'.$i, $rent );
            $manager->persist($rent);
        }

        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            ResidenceFixtures::class,
        ];
    }
}
