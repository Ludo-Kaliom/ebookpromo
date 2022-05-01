<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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
    public function findBestDiscounts($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.status = :val')
            ->orderBy('b.discountpercentage', 'DESC')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return Book[] Returns an array of Book objects
    */
    public function findMostCommented($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.status = :val')
            ->andWhere('b.nbcomments > 0')
            ->orderBy('b.nbcomments', 'DESC')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return Book[] Returns an array of Book objects
    */
    public function findMostPopular($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.status = :val')
            ->andWhere('b.nblikes > 0')
            ->orderBy('b.nblikes', 'DESC')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return Book[] Returns an array of Book objects
    */
    public function findByHeaderBooks()
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.status = :val')
            ->setParameter('val', true)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }

//     public function filteredByMachine(Subcategory $subcategory, QueryBuilder $queryBuilder): QueryBuilder
// {
//     $queryBuilder
//         ->innerJoin("b.subcategorie", "S")
//         ->andWhere("S.id = :subcatory")
//         ->setParameter("subcategry", $subcategory);
//     return $queryBuilder;
// }


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
