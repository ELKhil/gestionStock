<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    // /**
    //  * @return Produit[] Returns an array of Produit objects
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
    public function findOneBySomeField($value): ?Produit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function countBySearchProduct($keyword){
        $qb= $this->_getQbWithSearch($keyword);
        $qb->select('count(c.id)');
        // permet de récupérer une valeur unique et non un objet ou une collection
        return $qb->getQuery()->getSingleScalarResult();

    }

    public function findBySearchProduct($offset,$limit,$keyword){
        $qb= $this->_getQbWithSearch($keyword);
        $qb->setFirstResult($offset);
        $qb->setMaxResults($limit);


        return $qb->getQuery()->getResult();
        //getResult() // recupére une liste de résultat
        //getOneResult() // recuperer le premier resultat
        //return $qb->getQuery()->getResult();
    }

    private function _getQbWithSearch($keyword){
        //créer le constructeur de requet:
        $qb =  $this->createQueryBuilder('c');
        $qb ->where('c.deleted=0');

        if(($keyword)){
            $qb->andWhere('c.nom LIKE :p1 OR c.reference LIKE :p1 ');
            $qb->setParameter('p1', $keyword . '%');
        }
        return $qb;
    }
    public function countByRef($ref){
        //créer le constructeur de requet:
        $qb =  $this->createQueryBuilder('c');
        $qb->where('c.reference LIKE :p1 ');
        $qb->setParameter('p1', $ref . '%');
        $qb->select('COUNT(c.id)');
        return $qb->getQuery()->getSingleScalarResult();
    }
}
