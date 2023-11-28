<?php

namespace App\Repository;

use App\Entity\Seance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class SeanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Seance::class);
    }

    public function getSeancesFuturesParVille($ville){
        
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $qb->select('s')
            ->from('App\Entity\Seance', 's')
            ->where('s.dateHeureDepart > CURRENT_TIMESTAMP()')   //select all sessions with a start datetime that hasn't passed yet
            ->andWhere('s.ville = :ville')
            ->setParameter('ville', $ville)
            ->orderBy('s.dateHeureDepart');                      //order by start date (closer ones first)
        
        $query = $qb->getQuery();
        return $query->getResult();
    }


}
