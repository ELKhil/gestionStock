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
        $qb->select('count(p.id)');
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
        $qb =  $this->createQueryBuilder('p');
        $qb ->where('p.deleted=0');

        if(($keyword)){
            $qb->andWhere('p.nom LIKE :p1 OR p.reference LIKE :p1 ');
            $qb->setParameter('p1', $keyword . '%');
        }
        return $qb;
    }

    private function _getFilter($choice){
        //créer le constructeur de requet:
        $qb =  $this->createQueryBuilder('p');
        $qb ->where('p.deleted=0');
        if($choice === "Prix croissant") {
            $qb->orderBy("p.prix", 'asc');
        }
        if($choice === "Prix décroissant"){
            $qb->orderBy("p.prix", 'desc');
        }
        if($choice === "Stock")
            {
                $qb->orderBy("p.stock", 'desc');
            }
        return $qb;

    }
    public function countByRef($ref){
        //créer le constructeur de requet:
        $qb =  $this->createQueryBuilder('p');
        $qb->where('p.reference LIKE :p1 ');
        $qb->setParameter('p1', $ref . '%');
        $qb->select('COUNT(p.id)');
        return $qb->getQuery()->getSingleScalarResult();
    }
    public function filter($choice,$offset,$limit){

        $qb = $this->_getFilter($choice);
        $qb->setFirstResult($offset);
        $qb->setMaxResults($limit);
        return $qb->getQuery()->getResult();

    }

    public function findByname($name)
    {
            $qb= $this->createQueryBuilder('p');
            $qb->where('p.deleted = false' );
            $qb->andWhere('p.nom Like :p1');
            $qb->andWhere('p.stock > 0');
            $qb->setParameter('p1', $name.'%');

            $qb->orderBy('p.nom');

            $qb->setMaxResults(20);

            return $qb->getQuery()->getResult();

    }
}
