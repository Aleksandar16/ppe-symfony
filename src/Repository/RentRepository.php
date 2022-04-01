<?php

namespace App\Repository;

use App\Entity\Rent;
use App\Entity\Residence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Rent|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rent|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rent[]    findAll()
 * @method Rent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rent::class);
    }

    // /**
    //  * @return Rent[] Returns an array of Rent objects
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
    public function findOneBySomeField($value): ?Rent
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findResidence(Rent $rent): ?Rent
    {
        return $this->createQueryBuilder('residence')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $rent)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function findRentTenant(int $id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT rent
            FROM App\Entity\Rent rent
            INNER JOIN rent.tenant User
            WHERE User.id = :tenant'
        )->setParameter('tenant', $id);

        return $query->getResult();
    }

}
