<?php

namespace App\Controller;

use App\Entity\Medicament;
use App\Form\MedicamentType;
use App\Repository\FamilleRepository;
use App\Repository\InteractionRepository;
use App\Repository\MedicamentRepository;
use phpDocumentor\Reflection\Types\Integer;
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

        $medicament = new Medicament();


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
    public function show(Medicament $medicament, InteractionRepository $interactionRepository, $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $listeInteractions = $interactionRepository->findInteraction($id);

//        dd($listeInteractions);

        return $this->render('medicament/show.html.twig', [
            'medicament' => $medicament,
            'interaction' => $listeInteractions
        ]);
    }

    #[Route('/{id}/edit', name: 'medicament_edit', methods: ['GET','POST'])]
    public function edit(Request $request, FamilleRepository $familleRepository, MedicamentRepository $medicamentRepository, $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $listeFamille = $familleRepository->findAll();

        $medicament = $medicamentRepository->getUnMedic($id);

//        dd($request->request->get("medicament"));

        $default = [
            "nom" => $medicament[0]["MED_NOMCOMMERCIAL"],
            "famille" => $medicament[0]["fam_libelle"],
            "composition" => $medicament[0]["MED_COMPOSITION"],
            "effets" => $medicament[0]["MED_EFFETS"],
            "contre" => $medicament[0]["MED_CONTREINDIC"],
            "prix" => $medicament[0]["MED_PRIXECHANTILLON"],
        ];

//        if ($form->isSubmitted() && $form->isValid()) {
//            $this->getDoctrine()->getManager()->flush();
//
//            return $this->redirectToRoute('medicament_index', [], Response::HTTP_SEE_OTHER);
//        }

        if ($request->request->get("medicament")){
//            dd($request->request);
            $medicament = Medicament();

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

        return $this->renderForm('medicament/edit.html.twig', [
            'medicament' => $medicament,
            'familles' => $listeFamille,
            'default' => $default
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
