<?php

namespace App\Controller;

use App\Entity\Medicament;
use App\Form\MedicamentType;
use App\Repository\FamilleRepository;
use App\Repository\MedicamentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/medicament')]
class MedicamentController extends AbstractController
{
    #[Route('/', name: 'medicament_index', methods: ['GET'])]
    public function index(MedicamentRepository $medicamentRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $medicamentAll = $medicamentRepository->findFamille();
//        dd($medicamentAll);


        return $this->render('medicament/index.html.twig', [
            'medicaments' => $medicamentAll,
        ]);
    }

    #[Route('/new', name: 'medicament_new', methods: ['GET','POST'])]
    public function new(Request $request, FamilleRepository $familleRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $listeFamille = $familleRepository->findAll();

//        dd($listeFamille);
        $medicament = new Medicament();
//        $form = $this->createForm(MedicamentType::class, $medicament);
//        $form->handleRequest($request);

//        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($medicament);
//            $entityManager->flush();
//
//            return $this->redirectToRoute('medicament_index', [], Response::HTTP_SEE_OTHER);
//        }


        if ($request->request->get("medicament")){
//            dd($request->request);
            $medicament = new Medicament();
            $medicament->setMEDNOMCOMMERCIAL($request->request->get("medicament")["med_nomcommercial"]);
            $medicament->setFAMCODE($request->request->get("famille"));
            $medicament->setMEDCOMPOSITION($request->request->get("medicament")["med_composition"]);
            $medicament->setMEDEFFETS($request->request->get("medicament")["med_effets"]);
            $medicament->setMEDCONTREINDIC($request->request->get("medicament")["med_contreindic"]);
            $medicament->setMEDPRIXECHANTILLON($request->request->get("medicament")["med_prixechantillon"]);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($medicament);
            $entityManager->flush();

            return $this->redirectToRoute('medicament_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('medicament/new.html.twig', [
            'medicament' => $medicament,
            'familles' => $listeFamille
        ]);
    }

    #[Route('/{id}', name: 'medicament_show', methods: ['GET'])]
    public function show(Medicament $medicament): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->render('medicament/show.html.twig', [
            'medicament' => $medicament,
        ]);
    }

    #[Route('/{id}/edit', name: 'medicament_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Medicament $medicament): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(MedicamentType::class, $medicament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('medicament_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('medicament/edit.html.twig', [
            'medicament' => $medicament,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'medicament_delete', methods: ['POST'])]
    public function delete(Request $request, Medicament $medicament): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$medicament->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($medicament);
            $entityManager->flush();
        }

        return $this->redirectToRoute('medicament_index', [], Response::HTTP_SEE_OTHER);
    }
}
