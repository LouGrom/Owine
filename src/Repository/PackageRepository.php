<?php

namespace App\Repository;

use App\Entity\Package;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Package|null find($id, $lockMode = null, $lockVersion = null)
 * @method Package|null findOneBy(array $criteria, array $orderBy = null)
 * @method Package[]    findAll()
 * @method Package[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PackageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Package::class);
    }

    /**
     * @return bool Return a package if the bottleQuantity package already exist
     */
    public function findExistingPackage($companyId, $packageId)
    {
        // $builder est une instance de l'objet Query Builder
        $builder = $this->createQueryBuilder('package');

        $builder->where("package.company = :companyId");
        $builder->andWhere("package.id = :packageId");

        $builder->setParameter("companyId", $companyId);
        $builder->setParameter("packageId", $packageId);

        // on recupère la requete construite
        $query = $builder->getQuery();

        // on demande a doctrine d'éxecuter le requete et de me renvoyer les résultats
        return $query->getResult();

    }

    /**
     * @return Package[] Returns an array of Package objects
     */
    
    public function findAllByBottleQuantity($companyId)
    {
        return $this->createQueryBuilder('package')
            ->where('package.company = :companyId')
            ->setParameter('companyId', $companyId)
            ->orderBy('package.bottleQuantity', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    

    // /**
    //  * @return Package[] Returns an array of Package objects
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
    public function findOneBySomeField($value): ?Package
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
