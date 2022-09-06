<?php

namespace App\DataFixtures;


use App\Entity\Coordonnees;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CoordonneesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $timestamp = mt_rand(1, time());
        $date = new \DateTime ();
        $date->setTimestamp($timestamp);

        $coordonnees = new Coordonnees();
        $coordonnees->setDateDebutContrat($date);
        $coordonnees->setDateFinContrat($date);
        $coordonnees->setTelephone(1234567890);
        $coordonnees->setCommentaireRelation('It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum');
        $coordonnees->setRepresentative($this->getReference('user2'));
        $this->addReference('coordonnes1', $coordonnees);
        $manager->persist($coordonnees);

        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
