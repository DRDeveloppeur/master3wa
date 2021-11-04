<?php

namespace App\Repository;

use App\Entity\SubCategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SubCategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubCategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubCategorie[]    findAll()
 * @method SubCategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubCategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubCategorie::class);
    }

    // /**
    //  * @return SubCategorie[] Returns an array of SubCategorie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SubCategorie
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
