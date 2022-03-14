<?php

namespace App\Repository;

use App\Entity\Residence;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByRoleMandataire()
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.role LIKE :role')
            ->setParameter('role', '["ROLE_REPRESENTATIVE"]')
            ->getQuery()
            ->getResult();
    }

    public function findByRoleLocataire()
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.role LIKE :role')
            ->setParameter('role', '["ROLE_TENANT"]')
            ->getQuery()
            ->getResult();
    }

    public function findByResidence(User $user)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT residence
            FROM App\Entity\Residence residence
            INNER JOIN residence.representative User
            WHERE User.id = :residence'
        )->setParameter('residence', $user);

        return $query->getResult();
    }

    public function findRent(User $user)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT rent
            FROM App\Entity\Rent rent
            INNER JOIN rent.tenant User
            WHERE User.id = :tenant'
        )->setParameter('tenant', $user);

        return $query->getResult();
    }
}
