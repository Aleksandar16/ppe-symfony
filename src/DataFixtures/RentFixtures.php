<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Residence;
use App\Entity\Rent;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RentFixtures extends Fixture 
{
    public function load(ObjectManager $manager): void
    {
        //Date atélatoire
        $timestamp = mt_rand(1, time());
        $date = new \DateTime ();
        $date->setTimestamp($timestamp);

        for ($i = 0; $i < 20; $i++) {
            $rent = new Rent();
            //
            $rent->setTenant($this->getReference('Rent'.rand(0,20)));
            $countCategory = rand(0,20);
            if ($countCategory > 0)
            {
                for ($j=0; $j < $countCategory; $j++)
                {
                    $article->addCategory($this->getReference('User'.$j));
                }
            }
            $this->addReference('user-'.$i, $user);
            //
            $rent->setResidence($residence);
            $rent->setResidence($this->getReference('residence'.rand(0,20)));
            $countCategory = rand(0,20);
            if ($countCategory > 0)
            {
                for ($j=0; $j < $countCategory; $j++)
                {
                    $rent->addCategory($this->getReference('residence'.$j));
                }
            }
            $this->addReference('residence-'.$i, $residence);


            $rent->setInventoryFile('file'.rand(0,20).'.pdf');
            $rent->setDepartureDate($date);
            $rent->setArrivalDate($date);
            $rent->setTenantComments('It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum');
            $rent->setTenantSignature('It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum');
            $rent->setTenantValidated('It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum');
            $rent->setRepresentativeComments('It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum');
            $rent->setRepresentativeSignature('It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum');
            $rent->setRepresentativeValidatedAt($date);

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
