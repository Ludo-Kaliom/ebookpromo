<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

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

    public function findMostCommented()
    {
        // la table en base de données correspondant à l'entité liée au repository en cours
        $comment = $this->getClassMetadata()->table["Comment::class"];
        $book = $this->getClassMetadata()->table["Book::class"];
    
        // Dans mon cas je voulais trier mes résultats avec un ordre bien particulier
        $sql =  "SELECT b.id, b.title, c.book_id, c.content, COUNT(c.book_id) AS nb "
                ."FROM ".$comment." AS c, ".$book." AS b "
                ."WHERE (b.id = c.book_id)"
                ."GROUP BY b.title"
                ."ORDER BY nd = DESC";
    
        $rsm = new ResultSetMappingBuilder($this->getEntityManager());
        $rsm->addEntityResult(MyClass::class, "c");
    
        // On mappe le nom de chaque colonne en base de données sur les attributs de nos entités
        foreach ($this->getClassMetadata()->fieldMappings as $obj) {
            $rsm->addFieldResult("m", $obj["columnName"], $obj["fieldName"]);
        }
    
        $stmt = $this->getEntityManager()->createNativeQuery($sql, $rsm);
    
        $stmt->execute();
    
        return $stmt->getResult();
    }


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
