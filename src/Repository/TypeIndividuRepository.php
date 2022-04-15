<?php

namespace App\Repository;

use App\Entity\TypeIndividu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeIndividu|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeIndividu|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeIndividu[]    findAll()
 * @method TypeIndividu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeIndividuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeIndividu::class);
    }

    public function getUnType(int $leType){
        $entityManager = $this-> getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT ti.tin_libelle 
            FROM App\Entity\TypeIndividu as ti WHERE ti.id = :idType'
        )->setParameters(array('idType' => $leType));

        return $query->getResult();
    }

    public function getUnTypeParNom(string $leType){
        $entityManager = $this-> getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT ti.tin_libelle 
            FROM App\Entity\TypeIndividu as ti WHERE ti.tin_libelle = :leType'
        )->setParameters(array('leType' => $leType));

        return $query->getResult();
    }

    // /**
    //  * @return TypeIndividu[] Returns an array of TypeIndividu objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeIndividu
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
