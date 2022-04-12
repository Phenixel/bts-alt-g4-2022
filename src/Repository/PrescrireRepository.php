<?php

namespace App\Repository;

use App\Entity\Prescrire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Prescrire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prescrire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prescrire[]    findAll()
 * @method Prescrire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrescrireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prescrire::class);
    }

    public function findNomsPrescription(){
        $entityManager = $this-> getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p.id, m.MED_NOMCOMMERCIAL, t.tin_libelle, d.DOS_QUANTITE, d.DOS_UNITE
             FROM App\Entity\Medicament as m, App\Entity\TypeIndividu as t, App\Entity\Dosage as d, App\Entity\Prescrire as p
             WHERE m.id = p.Med_depotlegal AND t.id = p.tin_code AND d.id = p.dos_code'
        );

        return $query->getResult();
    }

    public function findPrescription(int $DepotLegal, int $tinCode, int $dosCode){
        $entityManager = $this-> getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT P.id FROM App\Entity\Prescrire as P WHERE Med_depotlegal = medDepot AND tin_code = tinCode AND dos_code = dosCode'
        )->setParameters(array('medDepot' => $DepotLegal, 'tinCode' => $tinCode, 'dosCode' => $dosCode));

        return $query->getResult();
    }

    // Retourne le nombre de prescription par type d'individu pour le graphe 2
    public function getPieChartPrescrire(){
        $entityManager = $this->getEntityManager()->getConnection();
        $query = 'SELECT type_individu.TIN_LIBELLE as libelle,COUNT(*) as total 
                    FROM `prescrire` INNER JOIN type_individu 
                    on prescrire.tin_code = type_individu.id 
                    GROUP BY type_individu.tin_libelle';
        $stmt=$entityManager->prepare($query);
        $rest=$stmt->executeQuery();
        return $rest->fetchAllAssociative();
    }

    // /**
    //  * @return Prescrire[] Returns an array of Prescrire objects
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
    public function findOneBySomeField($value): ?Prescrire
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
