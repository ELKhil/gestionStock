<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {

        parent::__construct($registry, Client::class);
    }

    // /**
    //  * @return Client[] Returns an array of Client objects
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
    public function findOneBySomeField($value): ?Client
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function countBySearch($keyword){
        $qb= $this->_getQbWithSearch($keyword);
        $qb->select('count(c.id)');
        // permet de récupérer une valeur unique et non un objet ou une collection
        return $qb->getQuery()->getSingleScalarResult();

    }



    public function findBySearch($offset,$limit,$keyword){
       $qb= $this->_getQbWithSearch($keyword);
        $qb->setFirstResult($offset);
        $qb->setMaxResults($limit);

        dump($qb->getQuery()->getResult());
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
            $qb->andWhere('c.nom LIKE :p1 OR c.prenom LIKE :p1 OR c.reference LIKE :p1 ');
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
