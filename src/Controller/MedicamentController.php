<?php

namespace App\Controller;

use App\Entity\Medicament;
use App\Form\MedicamentType;
use App\Repository\FamilleRepository;
use App\Repository\InteractionRepository;
use App\Repository\MedicamentRepository;
use App\Repository\PrescrireRepository;
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
    public function new(Request $request, FamilleRepository $familleRepository, MedicamentRepository $medicamentRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $listeFamille = $familleRepository->findAll();

        $medicament = new Medicament();


        if ($request->request->get("medicament")){

            $verifMedicament = $medicamentRepository->findMedicament($request->request->get("medicament")["med_nomcommercial"]);

            if (empty($verifMedicament) == false) {
                echo ("<script>alert('Ce médicament existe déjà.');</script>");
            }
            else {
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
        }

        return $this->renderForm('medicament/new.html.twig', [
            'medicament' => $medicament,
            'familles' => $listeFamille
        ]);
    }

    #[Route('/{id}', name: 'medicament_show', methods: ['GET'])]
    public function show(Medicament $medicament, InteractionRepository $interactionRepository, $id, FamilleRepository $familleRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $listeInteractions = $interactionRepository->findInteraction($id);
        $nomFamille = $familleRepository->findNomFamille($medicament->getFAMCODE());

//        dd($listeInteractions);

        return $this->render('medicament/show.html.twig', [
            'medicament' => $medicament,
            'interactions' => $listeInteractions,
            'nomFamille' => $nomFamille,
        ]);
    }

    #[Route('/{id}/edit', name: 'medicament_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Medicament $OMedicament,FamilleRepository $familleRepository, MedicamentRepository $medicamentRepository, $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $listeFamille = $familleRepository->findAll();
        $tabMedicament = $medicamentRepository->getUnMedic($id);

//        dd($request->request->get("medicament"));

        $default = [
            "nom" => $tabMedicament[0]["MED_NOMCOMMERCIAL"],
            "famille" => $tabMedicament[0]["fam_libelle"],
            "composition" => $tabMedicament[0]["MED_COMPOSITION"],
            "effets" => $tabMedicament[0]["MED_EFFETS"],
            "contre" => $tabMedicament[0]["MED_CONTREINDIC"],
            "prix" => $tabMedicament[0]["MED_PRIXECHANTILLON"],
        ];


//        dd($OMedicament);

        if ($request->request->get("medicament")){

                $OMedicament->setMEDNOMCOMMERCIAL($request->request->get("medicament")["med_nomcommercial"]);
                $OMedicament->setFAMCODE($request->request->get("famille"));
                $OMedicament->setMEDCOMPOSITION($request->request->get("medicament")["med_composition"]);
                $OMedicament->setMEDEFFETS($request->request->get("medicament")["med_effets"]);
                $OMedicament->setMEDCONTREINDIC($request->request->get("medicament")["med_contreindic"]);
                $OMedicament->setMEDPRIXECHANTILLON($request->request->get("medicament")["med_prixechantillon"]);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($OMedicament);
                $entityManager->flush();

                return $this->redirectToRoute('medicament_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('medicament/edit.html.twig', [
            'medicament' => $tabMedicament,
            'familles' => $listeFamille,
            'default' => $default
        ]);
    }

    #[Route('/{id}', name: 'medicament_delete', methods: ['POST'])]
    public function delete(Request $request, Medicament $medicament, PrescrireRepository  $prescrireRepository, InteractionRepository $interactionRepository,$id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$medicament->getId(), $request->request->get('_token'))) {
            if ($prescrireRepository->deletePresc($id)){
                $prescrireRepository->deletePresc($id);
            }
            if ($interactionRepository->deleteInter($id)){
                $interactionRepository->deleteInter($id);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($medicament);
            $entityManager->flush();
        }

        return $this->redirectToRoute('medicament_index', [], Response::HTTP_SEE_OTHER);
    }
}
