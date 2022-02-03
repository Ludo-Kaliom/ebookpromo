<?php

namespace App\Repository;

use App\Entity\BookLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BookLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookLike[]    findAll()
 * @method BookLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookLike::class);
    }

    public function countByBookAndUser($book, $user)
    {
        $qb = $this->createQueryBuilder('b')
            ->select('COUNT(b)')
            ->where('b.book = :book')
            ->andWhere('b.user = :user')
            ->setParameter('book', $book)
            ->setParameter('user', $user)
        ;
        return $qb->getQuery()->getSingleScalarResult();
    }

    // /**
    //  * @return BookLike[] Returns an array of BookLike objects
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
    public function findOneBySomeField($value): ?BookLike
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
