<?php

namespace App\Repository;

use App\Entity\Cart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cart|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cart|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cart[]    findAll()
 * @method Cart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cart::class);
    }

    /**
     * @return Cart[] Returns an array of Product objects
     */
    public function findAllByBuyer($id)
    {
        // $builder est une instance de l'objet Query Builder
        $builder = $this->createQueryBuilder('cart');

        $builder->where("cart.user = :userId");

        $builder->setParameter("userId", $id);

        // on recupère la requete construite
        $query = $builder->getQuery();

        // on demande a doctrine d'éxecuter le requete et de me renvoyer les résultats
        return $query->getResult();
    }

    /**
     * @return bool Return true if the cart already exist
     */
    public function findExistingCart($userId, $productId)
    {
        // $builder est une instance de l'objet Query Builder
        $builder = $this->createQueryBuilder('cart');

        $builder->where("cart.user = :userId");
        $builder->andWhere("cart.product = :productId");

        $builder->setParameter("userId", $userId);
        $builder->setParameter("productId", $productId);

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

    // /**
    //  * @return Cart[] Returns an array of Cart objects
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
    public function findOneBySomeField($value): ?Cart
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
