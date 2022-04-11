<?php

namespace App\DataFixtures;

// src/DataFixtures/AppFixtures.php
use App\Entity\Dosage;
use App\Entity\Famille;
use App\Entity\Interaction;
use App\Entity\Medicament;
use App\Entity\Prescrire;
use App\Entity\TypeIndividu;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class DataFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    // ...

    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
//        Familles
        $familles = array("Antalgique", "Analgésique", "Antidépresseur", "Anxiolytiques", "Antibiotique");
        $saveFamille = [];
        $f=0;
        foreach ($familles as $vFamille){
            $familles = new Famille();

            $familles->setFamLibelle($vFamille);
            $manager->persist($familles);
            $manager->flush();

            $saveFamille[$f] = $familles->getId();
            $f++;
        }

        //        Type Individu
        $typeIndividu = array("Femme","Adulte","Enfant","Adolescent","Femme enceinte","Personne âgée");
        $saveTypeIndividu = [];
        $ty = 0;
        foreach ($typeIndividu as $vTypeIndividu){
            $typeIndividu = new TypeIndividu();

            $typeIndividu->setTinLibelle($vTypeIndividu);
            $manager->persist($typeIndividu);
            $manager->flush();

            $saveTypeIndividu[$ty] = $typeIndividu->getId();
            $ty++;
        }

//        Médicament
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Bezhanov\Faker\Provider\Medicine($faker));
        $saveMedicament = [];

        for ($m = 0; $m < 500; $m++){
            $choseFam = random_int(1, (count($saveFamille)));

            $fcompo_contents = file(__DIR__ . "\compositions.txt");
            $lineCompo = $fcompo_contents[array_rand($fcompo_contents)];
            $dataComp = $lineCompo;

            $fcontre_contents = file(__DIR__ ."\contre.txt");
            $lineContre = $fcontre_contents[array_rand($fcontre_contents)];
            $dataContre = $lineContre;

            if ($choseFam == 1){
                $feffets1_contents = file(__DIR__ ."/effets1.txt");
                $lineEffets1 = $feffets1_contents[array_rand($feffets1_contents)];
                $dataEffets = $lineEffets1;
            }elseif ($choseFam == 2){
                $feffets2_contents = file(__DIR__ ."/effets2.txt");
                $lineEffets2 = $feffets2_contents[array_rand($feffets2_contents)];
                $dataEffets = $lineEffets2;
            }elseif ($choseFam == 3){
                $feffets3_contents = file(__DIR__ ."/effets3.txt");
                $lineEffets3 = $feffets3_contents[array_rand($feffets3_contents)];
                $dataEffets = $lineEffets3;
            }elseif ($choseFam == 4){
                $feffets4_contents = file(__DIR__ ."/effets4.txt");
                $lineEffets4 = $feffets4_contents[array_rand($feffets4_contents)];
                $dataEffets = $lineEffets4;
            }elseif ($choseFam == 5){
                $feffets5_contents = file(__DIR__ ."/effets5.txt");
                $lineEffets5 = $feffets5_contents[array_rand($feffets5_contents)];
                $dataEffets = $lineEffets5;
            }else{
                $dataEffets = "Aucun effet trouvé pour ce médicament.";
            }

            $medicament = new Medicament();
            $medicament->setMEDNOMCOMMERCIAL($faker->medicine);
            $medicament->setFAMCODE($choseFam);
            $medicament->setMEDCOMPOSITION($dataComp);
            $medicament->setMEDCONTREINDIC($dataContre);
            $medicament->setMEDEFFETS($dataEffets);
            $medicament->setMEDPRIXECHANTILLON(random_int(10, 300)/10);

            $manager->persist($medicament);
            $manager->flush();

            $saveMedicament[$m] = $medicament->getId();
        }

//        Dosage
        $dosQuantite = ["2 Pillules","1 comprimé",
            "1 cuillère à café","10 cl",
            "1 sachet","1 ampoule",
            "1 seringue","30 cl",
            "1 patch","1 suppositoire"
        ];
        $dosUnite = ["3 fois par jours","2 fois par jours",
            "autant que nécessaire", "Tous les soirs",
            "Après chaque repas","Au réveil",
            "Avant de dormir","En cas de douleur",
            "Tous les 3 heures","Tous les 6 heures"
        ];
        $saveDosage = [];
        $d=0;
        foreach ($dosQuantite as $vDosage){
            $dosage = new Dosage();
            $dosage->setDOSQUANTITE($vDosage);

            foreach ($dosUnite as $vUDosage){
                $dosage->setDOSUNITE($vUDosage);
            }

            $manager->persist($dosage);
            $manager->flush();

            $saveDosage[$d] = $dosage->getId();
            $d++;
        }

//        Interactions
        for ($i = 0; $i < 20; $i++){
            $interaction = new Interaction();
            $posMedic = random_int(0, (count($saveMedicament) - 1));
            $posMedic2 = random_int(0, (count($saveMedicament) - 1));

            if ($posMedic !== $posMedic2){
                $interaction->setMEDMEDPERTURBE($posMedic);
                $interaction->setMEDPERTURBATEUR($posMedic2);

                $manager->persist($interaction);
                $manager->flush();
            }else{
                --$i;
            }
        }

//        Prescriptions
        for ($i = 0; $i < 20; $i++){
            $lesPrescriptions = new Prescrire();
            $depotLegal = random_int(0, (count($saveMedicament) - 1));
            $tinCode = random_int(1, 6);
            $dosCode = random_int(1, 10);

            $lesPrescriptions->setMedDepotlegal($depotLegal);
            $lesPrescriptions->setTinCode($tinCode);
            $lesPrescriptions->setDosCode($dosCode);


            $manager->persist($lesPrescriptions);
            $manager->flush();
        }

    }
}
