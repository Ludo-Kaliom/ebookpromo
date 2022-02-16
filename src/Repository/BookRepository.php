<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
    * @return Book[] Returns an array of Book objects
    */
    public function findBestDiscounts()
    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.totalprice', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

     /**
    * @return Book[] Returns an array of Book objects
    */
    public function findMostCommented()
    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.nbcomments', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return Book[] Returns an array of Book objects
    */
    public function findMostPopular()
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        return    $qb->select('b')
        ->from('App\Entity\Book', 'b')
        ->leftJoin('App\Entity\BookLike', 'c', 'WITH', 'b.id=c.book')
        ->addSelect( 'count(c.book) AS like_count')
        ->addSelect( 'b.cover')
        ->groupBy('c.book')
        ->orderBy('like_count', 'DESC')
        ->setFirstResult( '0')
        ->setMaxResults( '10' )
        ->getQuery()
        // ->getSQL(); // permet de récuperer une conversion en sql utile pour debugger
        ->getResult();
    }


    // /**
    //  * @return Book[] Returns an array of Book objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Book
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
