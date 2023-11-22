<?php

namespace App\Repository;

use App\Entity\Topic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Topic>
 *
 * @method Topic|null find($id, $lockMode = null, $lockVersion = null)
 * @method Topic|null findOneBy(array $criteria, array $orderBy = null)
 * @method Topic[]    findAll()
 * @method Topic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TopicRepository extends ServiceEntityRepository
{
    public function getLatestTopics(){
        
        $idCategoriesExclues = [6, 7];

        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $qb->select('t')
            ->from('App\Entity\Topic', 't')
            ->leftJoin('t.categorie', 'c')
            ->where('c.id NOT IN (:categoriesExclues)')
            ->setParameter('categoriesExclues', $idCategoriesExclues)
            ->orderBy('t.dateCreation', 'DESC')
            ->setMaxResults(10);
        
        $query = $qb->getQuery();
        return $query->getResult();
    }


    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Topic::class);
    }

}
