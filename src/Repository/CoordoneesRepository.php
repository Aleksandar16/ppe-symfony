<?php

namespace App\Repository;

use App\Entity\Coordonees;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Coordonees|null find($id, $lockMode = null, $lockVersion = null)
 * @method Coordonees|null findOneBy(array $criteria, array $orderBy = null)
 * @method Coordonees[]    findAll()
 * @method Coordonees[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoordoneesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coordonees::class);
    }

    // /**
    //  * @return Coordonees[] Returns an array of Coordonees objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Coordonees
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
