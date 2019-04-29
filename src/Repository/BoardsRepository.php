<?php

namespace App\Repository;

use App\Entity\Boards;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Boards|null find($id, $lockMode = null, $lockVersion = null)
 * @method Boards|null findOneBy(array $criteria, array $orderBy = null)
 * @method Boards[]    findAll()
 * @method Boards[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoardsRepository extends ServiceEntityRepository {
	
    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, Boards::class); }

    // /**
    //  * @return Boards[] Returns an array of Boards objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Boards
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
