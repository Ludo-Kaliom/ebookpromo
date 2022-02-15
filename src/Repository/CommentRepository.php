<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

//     public function findMostCommented()
//     {
//             $em = $this->getEntityManager();

//             //on recupère le nom des tables
//             $comment = $em->getClassMetadata("App\Entity\Comment")->getTableName();
//             $book = $em->getClassMetadata("App\Entity\Book")->getTableName();

//             $conn = $this->getEntityManager()->getConnection();

//             $sql = 'SELECT b.id, b.cover, b.reduceprice, b.normalprice, c.book_id, c.content, COUNT(c.book_id) AS nb
//                     FROM '.$comment.' AS c, '.$book.' AS b 
//                     WHERE (b.id = c.book_id)
//                     GROUP BY b.id
//                     ORDER BY nb DESC';
//             $stmt = $conn->prepare($sql);
//             $resultSet = $stmt->executeQuery();

//             // returns an array of arrays (i.e. a raw data set)
//             return $resultSet->fetchAllAssociative();
// }

    // /**
    //  * @return Comment[] Returns an array of Comment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Comment
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
