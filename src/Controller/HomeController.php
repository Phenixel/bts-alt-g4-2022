<?php

namespace App\Controller;

use App\Repository\PrescrireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PrescrireRepository $PrescrireRepository): Response
    {

        $fonctionDoughnut = $PrescrireRepository->getPieChartPrescrire();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'fonctionDoughnut'=>$fonctionDoughnut
        ]);


    }
}
