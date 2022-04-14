<?php

namespace App\Controller;

use App\Repository\MedicamentRepository;
use App\Repository\PrescrireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PrescrireRepository $PrescrireRepository, MedicamentRepository $medicamentRepository): Response
    {

//        Graphiques
        $fonctionDoughnut = $PrescrireRepository->getPieChartPrescrire();
        $chartPolar = $medicamentRepository->getChartMedParFam();

//        Prescriptions + & -
        $maxPrescrit = $medicamentRepository->maxPrescrit();
        $minPrescrit = $medicamentRepository->minPrescrit();

//        dd($maxPrescrit);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'fonctionDoughnut'=>$fonctionDoughnut,
            'chartPolar'=>$chartPolar,
            'maxPrescrit'=>$maxPrescrit,
            'minPrescrit'=>$minPrescrit
        ]);


    }
}
