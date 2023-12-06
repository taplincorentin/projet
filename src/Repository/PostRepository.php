<?php

namespace App\Repository;

use App\Entity\Post;
use App\Entity\Topic;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;


class PostRepository extends ServiceEntityRepository
{
    public function nbPostsDansTopic(Topic $topic) :int {
        
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $qb->select('COUNT(p.id)')
            ->from('App\Entity\Post', 'p')
            ->where('p.topic = :topic')
            ->setParameter('topic', $topic);
        
        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }
    
    public function nbPostsAuteur($auteur){

        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $qb ->select('COUNT(p.id)')
            ->from('App\Entity\Post', 'p')
            ->where('p.auteur = :auteur')
            ->setParameter('auteur', $auteur);
        
        $query = $qb->getQuery();
        
        return $query->getSingleScalarResult();
    }

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

}
