<?php

namespace App\Repository;

use App\Entity\ChienRaces;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ChienRaces>
 *
 * @method ChienRaces|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChienRaces|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChienRaces[]    findAll()
 * @method ChienRaces[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChienRacesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChienRaces::class);
    }

//    /**
//     * @return ChienRaces[] Returns an array of ChienRaces objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ChienRaces
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
