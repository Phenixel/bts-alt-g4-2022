<?php

namespace App\Repository;

use App\Entity\Medicament;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Medicament|null find($id, $lockMode = null, $lockVersion = null)
 * @method Medicament|null findOneBy(array $criteria, array $orderBy = null)
 * @method Medicament[]    findAll()
 * @method Medicament[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MedicamentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Medicament::class);
    }

    public function findFamille(){
        $entityManager = $this-> getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT m.id, m.MED_NOMCOMMERCIAL, f.fam_libelle, m.MED_COMPOSITION, m.MED_EFFETS, m.MED_CONTREINDIC, m.MED_PRIXECHANTILLON
            FROM App\Entity\Medicament as m, App\Entity\Famille as f
            WHERE f.id = m.FAM_CODE'
        );

        return $query->getResult();
    }

    public function getUnMedic(int $leMedic){
        $entityManager = $this-> getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT m.id, m.MED_NOMCOMMERCIAL, f.fam_libelle, m.MED_COMPOSITION, m.MED_EFFETS, m.MED_CONTREINDIC, m.MED_PRIXECHANTILLON
            FROM App\Entity\Medicament as m, App\Entity\Famille as f
            WHERE f.id = m.FAM_CODE AND m.id = :idMedic'
        )->setParameters(array('idMedic' => $leMedic));

        return $query->getResult();
    }

//    public function setModifMedic(string $nomMedic, int $famCode, string $compo, string $effets, string $contre, float $prix, int $leMedic){
//        $entityManager = $this-> getEntityManager();
//
//        $query = $entityManager->createQuery(
//            'UPDATE App\Entity\Medicament
//            SET MED_NOMCOMMERCIAL = :nom ,FAM_CODE = :fam,MED_COMPOSITION = :compo,MED_EFFETS = :effets,MED_CONTREINDIC = :contre,MED_PRIXECHANTILLON = :prix WHERE MED_DEPOTLEGAL = :idMedic'
//        )->setParameters(array(
//            'nom' => $nomMedic,
//            'fam' =>$famCode,
//            'compo' => $compo,
//            'effets' => $effets,
//            'contre' => $contre,
//            'prix' => $prix,
//            'idMedic' => $leMedic
//        ));
//
//        return $query->getResult();
//    }

    public function maxPrescrit(){
        $entityManager = $this->getEntityManager()->getConnection();

        $query = 'SELECT medicament.MED_NOMCOMMERCIAL as nomMedic
        FROM medicament
        INNER JOIN prescrire ON medicament.id=prescrire.MED_DEPOTLEGAL
        GROUP BY medicament.MED_NOMCOMMERCIAL
        HAVING COUNT(*) = ( SELECT MAX(nb) FROM (SELECT MED_DEPOTLEGAL,COUNT(MED_DEPOTLEGAL) as nb FROM prescrire GROUP BY med_depotlegal) as temp)';

        $stmt = $entityManager->prepare($query);
        $rest = $stmt->executeQuery();

        return $rest->fetchAllAssociative();
    }

    public function minPrescrit(){
        $entityManager = $this->getEntityManager()->getConnection();

        $query = 'SELECT medicament.MED_NOMCOMMERCIAL as nomMedic
        FROM medicament
        INNER JOIN prescrire ON medicament.id=prescrire.MED_DEPOTLEGAL
        GROUP BY medicament.MED_NOMCOMMERCIAL
        HAVING COUNT(*) = ( SELECT MIN(nb) FROM (SELECT MED_DEPOTLEGAL,COUNT(MED_DEPOTLEGAL) as nb FROM prescrire GROUP BY med_depotlegal) as temp)';

        $stmt = $entityManager->prepare($query);
        $rest = $stmt->executeQuery();

        return $rest->fetchAllAssociative();
    }

    public function getChartMedParFam(){
        $entityManager = $this->getEntityManager()->getConnection();
        $query = 'SELECT famille.FAM_LIBELLE as libelle, COUNT(*) as total 
                FROM medicament 
                INNER JOIN famille on medicament.FAM_CODE = famille.id 
                GROUP BY famille.FAM_LIBELLE';
        $stmt=$entityManager->prepare($query);
        $rest=$stmt->executeQuery();
        return $rest->fetchAllAssociative();
    }

    public function findMedicament(string $medNom){
        $entityManager = $this-> getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT m.id FROM App\Entity\Medicament as m WHERE m.MED_NOMCOMMERCIAL = :medNom'
        )->setParameters(array('medNom' => $medNom));

        return $query->getResult();
    }

    // /**
    //  * @return Medicament[] Returns an array of Medicament objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Medicament
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
