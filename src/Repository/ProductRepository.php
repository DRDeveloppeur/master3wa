<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * Undocumented function
     *
     * @return Product[]
     */
    public function findSearch(SearchData $search): array
    {
        $filters = [];
        $query = $this
            ->createQueryBuilder('p')
            ->select('c', 'p')
            ->select('m', 'p')
            ->select('sc', 'p')
            ->select('DISTINCT size', 'p')
            ->select('DISTINCT discount', 'p')
            ->join('p.categorie_id', 'c')
            ->join('p.mark_id', 'm')
            ->join('p.sub_categorie_id', 'sc')
            ->join('p.stocks', 'size')
            ->join('p.stocks', 'discount')
        ;
        if (!empty($search->q)) {
            $query = $query
                ->andWhere('p.model LIKE :q OR m.name LIKE :q OR c.name LIKE :q OR p.ray LIKE :q OR sc.name LIKE :q OR p.ref LIKE :q')
                ->setParameter('q', "%{$search->q}%")
            ;
            array_push($filters, ["q" => $search->q]);
        }
        if (!empty($search->promo)) {
            $query = $query
                ->andWhere('discount.discount >= 1')
            ;
            array_push($filters, ["promo" => $search->promo]);
        }
        if (!empty($search->categories)) {
            $query = $query
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $search->categories)
            ;
            array_push($filters, ["categories" => $search->categories]);
        }
        if (!empty($search->marques)) {
            $query = $query
                ->andWhere('m.id IN (:marques)')
                ->setParameter('marques', $search->marques)
            ;
            array_push($filters, ["marques" => $search->marques]);
        }
        if (!empty($search->subCategories)) {
            $query = $query
                ->andWhere('sc.id IN (:subCategories)')
                ->setParameter('subCategories', $search->subCategories)
            ;
            array_push($filters, ["subCategories" => $search->subCategories]);
        }
        if (!empty($search->sizes)) {
            $result = [];
            foreach ($search->sizes as $key => $value) {
                $query = $query
                    ->andWhere('size.size LIKE :sizes')
                    ->setParameter('sizes', "%{$value}%");
                $products = $query->getQuery()->getResult();
                if (is_array($products)) {
                    foreach ($products as $key => $value) {
                        array_push($result, $value);
                    }
                } else {
                    array_push($result, $query->getQuery()->getResult());
                }
            }
            array_push($filters, ["sizes" => $search->sizes]);

            $res = ["filters" => $filters, "result" => $result];
            return $res;
        }

        $res = ["filters" => $filters, "result" => $query->getQuery()->getResult()];
        return $res;
    }

        /**
     * Undocumented function
     *
     * @return Product[]
     */
    public function findLastAdded(): array
    {
        $query = $this
            ->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
        
        $res = $query;
        return $res;
    }
}
