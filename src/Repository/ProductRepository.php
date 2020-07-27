<?php

namespace App\Repository;

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

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findAllByCompany($id)
    {
        // $builder est une instance de l'objet Query Builder
        $builder = $this->createQueryBuilder('product');

        $builder->where("product.company = :companyId");

        $builder->setParameter("companyId", $id);

        // on recupère la requete construite
        $query = $builder->getQuery();

        // on demande a doctrine d'éxecuter le requete et de me renvoyer les résultats
        return $query->getResult();

        /* ->andWhere('user.id = :val')
            ->setParameter('sellerId', $id)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;*/
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findAllSortByPrice($growingPrice)
    {
        // $builder est une instance de l'objet Query Builder
        $builder = $this->createQueryBuilder('product');

        if($growingPrice == true){
            $builder->addOrderBy('product.price', 'ASC');
        } else {
            $builder->addOrderBy('product.price', 'DESC');
        }

        $query = $builder->getQuery();
        return $query->getResult();
    }

    /**
     * @return Product[] Return an array of Poducty objects
     */
    public function searchProduct($search, $growingPrice = true)
    {

        // $builder est une instance de l'objet Query Builder
        $builder = $this->createQueryBuilder('product');
        $builder->leftJoin('product.appellation', 'appellation');
        // $builder->addSelect('appellation');
        $builder->where('product.cuveeDomaine LIKE :search');
        $builder->orWhere('appellation.name LIKE :search');
        $builder->setParameter('search', "%$search%");
        $builder->setParameter('search', "%$search%");
        
        if($growingPrice == true){
            $builder->orderBy('product.price', 'ASC');
        } else {
            $builder->orderBy('product.price', 'DESC');
        }
        $query = $builder->getQuery();       
        return $query->getResult();
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findAllByAppellation($appellation)
    {
        // $builder est une instance de l'objet Query Builder
        $builder = $this->createQueryBuilder('product');
        
        $builder->where("product.appellation = :appellation");

        $builder->setParameter("appellation", $appellation);

        $query = $builder->getQuery();
        return $query->getResult();
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findWithAllData($id)
    {

        $builder = $this->createQueryBuilder('product');
        $builder->where("product.id = :productId");
        $builder->setParameter("productId", $id);
        $builder->leftJoin('product.categories', 'category');
        $builder->addSelect('category');

        $builder->leftJoin('product.types', 'type');
        $builder->addSelect('type');

        $query = $builder->getQuery();
        return $query->getOneOrNullResult();
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

}
