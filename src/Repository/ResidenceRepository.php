<?php

namespace App\Repository;

use App\Entity\Residence;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Residence|null find($id, $lockMode = null, $lockVersion = null)
 * @method Residence|null findOneBy(array $criteria, array $orderBy = null)
 * @method Residence[]    findAll()
 * @method Residence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResidenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Residence::class);
    }

    // /**
    //  * @return Residence[] Returns an array of Residence objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Residence
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByResidence(Residence $bien)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT rent
            FROM App\Entity\Rent rent
            INNER JOIN rent.residence Residence
            WHERE Residence.id = :residence'
        )->setParameter('residence', $bien);

        return $query->getResult();
    }

    public function findResidenceRepresentative(int $id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT residence
            FROM App\Entity\Residence residence
            INNER JOIN residence.representative User
            WHERE User.id = :representative'
        )->setParameter('representative', $id);

        return $query->getResult();
    }
}
