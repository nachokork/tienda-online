<?php

namespace App\Repository\Product;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function getProducts(){
        $query = $this->createQueryBuilder('p');
        return $query->getQuery()->getResult();
    }

    public function getProductById($id){
        $query = $this->createQueryBuilder('p');
        $query->andWhere('p.id = :id')
            ->setParameter('id', $id);
        return $query->getQuery()->getOneOrNullResult();
    }

    public function deleteProductById($id)
    {
        try {
            $this->getEntityManager()->remove($this->getProductById($id));
            $this->getEntityManager()->flush();
            return new JsonResponse(["succes", 200]);
        } catch (NonUniqueResultException $e) {

        }
        return new JsonResponse(["error", 500]);
    }

    public function save(Product $product): JsonResponse
    {
        try {
            $this->getEntityManager()->persist($product);
            $this->getEntityManager()->flush();
            return new JsonResponse(["succes", 200]);
        } catch (\Exception $e) {
            return new JsonResponse(["error", 500]);
        }
    }
    //    /**
    //     * @return Product[] Returns an array of Product objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Product
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
