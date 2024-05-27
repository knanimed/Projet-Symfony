<?php

namespace App\Repository;

use App\Entity\Book;
use App\Entity\Author;
use App\Entity\Bookauthor;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Bookauthor>
 *
 * @method Bookauthor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bookauthor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bookauthor[]    findAll()
 * @method Bookauthor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookauthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bookauthor::class);
    }

    public function save(Book $book, Author $author): void
    {
        $bookauthor = new Bookauthor();
        $bookauthor->setBookId($book);
        $bookauthor->setAuthorId($author);

        $entityManager = $this->getEntityManager();
        $entityManager->persist($bookauthor);
        $entityManager->flush();
    }
    public function deleteByBookId(Book $book): void
    {
        $qb = $this->createQueryBuilder('ba')
            ->delete()
            ->where('ba.book_id = :book')
            ->setParameter('book', $book)
            ->getQuery();

        $qb->execute();
    }

    //    /**
    //     * @return Bookauthor[] Returns an array of Bookauthor objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Bookauthor
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
