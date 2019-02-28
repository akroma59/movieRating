<?php

namespace App\Repository;

use App\Entity\Evaluation;
use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Evaluation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evaluation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evaluation[]    findAll()
 * @method Evaluation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvaluationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Evaluation::class);
    }

    public function getBestEval(Movie $movie)
    {
        return $this->createQueryBuilder('e')
                ->where('e.movie = :movie')
                ->orderBy('e.grade', 'DESC')
                ->setFirstResult( 0 )
                ->setMaxResults( 3 )
                ->setParameter('movie', $movie)
                ->getQuery()
                ->getResult()
            ;
    }

    public function getWorstEval(Movie $movie)
    {
        return $this->createQueryBuilder('e')
            ->where('e.movie = :movie')
            ->orderBy('e.grade', 'ASC')
            ->setFirstResult( 0 )
            ->setMaxResults( 3 )
            ->setParameter('movie', $movie)
            ->getQuery()
            ->getResult()
            ;
    }
    // /**
    //  * @return Evaluation[] Returns an array of Evaluation objects
    //  */
    
    // public function getEvalByMovieId(Evaluation $evaluation , Movie $movie)
    // {
    //     return $this->createQueryBuilder('e')
    //         ->select()
    //         // ->leftJoin()            
    //         // ->andWhere('e.movie_id = :m.id')
    //         // ->setParameter('m.id', $movie)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }
    

    /*
    public function findOneBySomeField($value): ?Evaluation
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
