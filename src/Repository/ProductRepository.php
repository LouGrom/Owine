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
    public function findAllBySeller($id)
    {
        // $builder est une instance de l'objet Query Builder
        $builder = $this->createQueryBuilder('product');

        $builder->where("product.seller = :sellerId");

        $builder->setParameter("sellerId", $id);

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
    public function findWithAllData($id)
    {

        $builder = $this->createQueryBuilder('product');
        // je souhaite sécuriser le parametre $id
        $builder->where("product.id = :productId");
        // je precise au builder quelle valeur "injecter" dans le parametre :animeId
        // Cetete methode sécurise le contenu de la variable $id (echapment de car spéciaux ...)
        $builder->setParameter("productId", $id);

        // Je demande a doctrine de faire la jointure avec la relation ->categories
        $builder->leftJoin('product.categories', 'category');
        // je demande a doctrien d'alimenter les objets de type Category dans mon objet Anime
        $builder->addSelect('category');

        $builder->leftJoin('product.types', 'type');
        // "tu rajoute aux resultats que tu me renvoi les objets de type Character"
        $builder->addSelect('type');

        // on recupère la requete construite
        $query = $builder->getQuery();

        // je demande a doctrine d'éxecuter le requete et de me renvoyer les resultats
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
