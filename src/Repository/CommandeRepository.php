<?php

namespace App\Repository;

use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\Etats;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commande::class);
    }

    // /**
    //  * @return Commande[] Returns an array of Commande objects
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
    public function findOneBySomeField($value): ?Commande
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function countByRef($ref){
        //créer le constructeur de requet:
        $qb =  $this->createQueryBuilder('c');
        $qb->where('c.reference LIKE :p1 ');
        $qb->setParameter('p1', $ref . '%');
        $qb->select('COUNT(c.id)');
        return $qb->getQuery()->getSingleScalarResult();
    }


    public function search(?string $ref = null, ?Client $refClient = null, ?\DateTime $startAt = null, ?\DateTime $endAt = null, mixed $state = null) {
        $qb = $this->createQueryBuilder("c");

        if ($ref != null) {
            $qb->where("c.reference = :ref");
            $qb->setParameter("ref", $ref);
        }
        if ($refClient != null) {
            $qb->andWhere("c.client = :client");
            $qb->setParameter("client", $refClient);
        }

        if ($startAt != null && $endAt != null) {
            $qb->andWhere("c.creationDate between :d and :c");
            $qb->setParameter("d" , $startAt);
            $qb->setParameter("c" , $endAt);
        }

        if($state != null){
            $qb->andWhere("c.etat = :d");
            $qb->setParameter("d", $state);
        }


        return $qb->getQuery()->getResult();
    }

    public function findWithClient(int $id)
    {

        //select c.* From commande as c
        $qb = $this->createQueryBuilder('c');
        //Where id =:p1
        $qb->where('c.id = :p1');
        $qb->setParameter('p1', $id);
        //LeftJoin client as cl On cl.id = c.clientID
        $qb->leftJoin('c.client','cl' );
        $qb->addSelect('cl');

        //si on sait qu'on va récupérer qu'une seule résultat
        return $qb->getQuery()->getOneOrNullResult();
    }

    public function findWithLinesAndProducts($id)
    {
        $qb =$this->createQueryBuilder('c');
        $qb->where("c.id = :p1");
        $qb->setParameter('p1' , $id);

        $qb->leftJoin('c.lignes' , 'l');
        $qb->leftJoin('l.produit_id' , 'p');

        $qb->addSelect('l');
        $qb->addSelect('p');

        return $qb->getQuery()->getOneOrNullResult();

    }


}
