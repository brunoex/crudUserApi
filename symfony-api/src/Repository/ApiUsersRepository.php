<?php

namespace App\Repository;

use App\Entity\ApiUsers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ApiUsers|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApiUsers|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApiUsers[]    findAll()
 * @method ApiUsers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApiUsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApiUsers::class);
    }

    // /**
    //  * @return ApiUsers[] Returns an array of ApiUsers objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ApiUsers
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
