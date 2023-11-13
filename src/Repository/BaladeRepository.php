<?php

namespace App\Repository;

use App\Entity\Balade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Balade>
 *
 * @method Balade|null find($id, $lockMode = null, $lockVersion = null)
 * @method Balade|null findOneBy(array $criteria, array $orderBy = null)
 * @method Balade[]    findAll()
 * @method Balade[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BaladeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Balade::class);
    }

//    /**
//     * @return Balade[] Returns an array of Balade objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Balade
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
