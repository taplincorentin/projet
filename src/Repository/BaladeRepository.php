<?php

namespace App\Repository;

use App\Entity\Balade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BaladeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Balade::class);
    }

    public function getBaladesFuturesParVille($ville){
        
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $qb->select('b')
            ->from('App\Entity\Balade', 'b')
            ->where('b.dateHeureDepart > CURRENT_TIMESTAMP()')   //select all walks with a start datetime that hasn't passed yet
            ->andWhere('b.ville = :ville')
            ->setParameter('ville', $ville)
            ->orderBy('b.dateHeureDepart');                      //order by start date (closer ones first)
        
        $query = $qb->getQuery();
        return $query->getResult();
    }
}    