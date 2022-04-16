<?php

namespace App\Repository;

use App\Entity\Interaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Integer;

/**
 * @method Interaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Interaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Interaction[]    findAll()
 * @method Interaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InteractionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Interaction::class);
    }

    public function findInteraction(int $idMedic){
        $entityManager = $this-> getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT m.MED_NOMCOMMERCIAL FROM App\Entity\Medicament as m, App\Entity\Interaction as i 
            WHERE i.MED_MED_PERTURBE = m.id AND i.MED_PERTURBATEUR = :idMedic'
        )->setParameters(array('idMedic' => $idMedic));

        return $query->getResult();
    }

    public function deleteUneInteraction(int $idMedic){
        $entityManager = $this->getEntityManager()->getConnection();

        $query = 'DELETE FROM interaction
        WHERE id in (SELECT interaction.id FROM interaction
        INNER JOIN medicament on interaction.med_perturbateur = medicament.id
        WHERE medicament.id = ' .$idMedic. ')';

        $stmt = $entityManager->prepare($query);
        $rest = $stmt->executeQuery();

        return $rest->fetchAllAssociative();
    }

    // /**
    //  * @return Interaction[] Returns an array of Interaction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Interaction
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
