<?php

namespace App\Controller;

use App\Entity\Prescrire;
use App\Form\PrescrireType;
use App\Repository\PrescrireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MedicamentRepository;
use App\Repository\TypeIndividuRepository;
use App\Repository\DosageRepository;

#[Route('/prescrire')]
class PrescrireController extends AbstractController
{
    #[Route('/', name: 'prescrire_index', methods: ['GET'])]
    public function index(PrescrireRepository $prescrireRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $prescrireAll = $prescrireRepository->findNomsPrescription();

        return $this->render('prescrire/index.html.twig', [
            'prescrires' => $prescrireAll,
        ]);
    }

    #[Route('/new', name: 'prescrire_new', methods: ['GET','POST'])]
    public function new(Request $request, MedicamentRepository $MedicamentRepository, TypeIndividuRepository $TypeIndividuRespository, DosageRepository $DosageRepository, PrescrireRepository $prescrireRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $listeMedicament = $MedicamentRepository->findAll();
        $listeTY = $TypeIndividuRespository->findAll();
        $listeDosage = $DosageRepository->findAll();
        $prescrire = new Prescrire();


//        dd($request->request);

        if ($request->request->has("medicament")) {

            $prescription = $prescrireRepository->findPrescription(intval($request->request->get("medicament")),intval($request->request->get("individu")),intval($request->request->get("dosage")));

            if (empty($prescription) == false) {
                echo ("<script>alert('Cette prescription existe déjà.');</script>");
            }
            else {
                $prescrire = new Prescrire();
                $prescrire->setMedDepotlegal($request->request->get("medicament"));
                $prescrire->setTinCode($request->request->get("individu"));
                $prescrire->setDosCode($request->request->get("dosage"));
                //            dd($request->request);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($prescrire);
                $entityManager->flush();

                return $this->redirectToRoute('prescrire_index', [], Response::HTTP_SEE_OTHER);
            }
        }


        return $this->renderForm('prescrire/new.html.twig', [
            'prescrire' => $prescrire,
            'medicaments' => $listeMedicament,
            'individus' => $listeTY,
            'dosages' => $listeDosage

        ]);
    }

    #[Route('/{id}', name: 'prescrire_show', methods: ['GET'])]
    public function show(Prescrire $prescrire, PrescrireRepository $prescrireRepository, $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $prescrire = $prescrireRepository->getUnePrescription(intval($id));

        return $this->render('prescrire/show.html.twig', [
            'prescrire' => $prescrire,
        ]);
    }

    #[Route('/{id}/edit', name: 'prescrire_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Prescrire $OPrescrire, PrescrireRepository $prescrireRepository, MedicamentRepository $MedicamentRepository, TypeIndividuRepository $TypeIndividuRespository, DosageRepository $DosageRepository, $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

//        dd($request);

        $listeMedicament = $MedicamentRepository->findAll();
        $listeTY = $TypeIndividuRespository->findAll();
        $listeDosage = $DosageRepository->findAll();
        $tabPrescrire = $prescrireRepository->getUnePrescription($id);

        $default = [
            "nomMedoc" => $tabPrescrire[0]["MED_NOMCOMMERCIAL"],
            "nomType" => $tabPrescrire[0]["tin_libelle"],
            "dosQuantite" => $tabPrescrire[0]["DOS_QUANTITE"],
            "dosUnite" => $tabPrescrire[0]["DOS_UNITE"],
        ];

        if ($request->request->has("medicament")) {

            $prescription = $prescrireRepository->findPrescription(intval($request->request->get("medicament")),intval($request->request->get("individu")),intval($request->request->get("dosage")));

            if (empty($prescription) == false) {
                echo ("<script>alert('Cette prescription existe déjà.');</script>");
            }
            else {

                $OPrescrire->setMedDepotlegal($request->request->get("medicament"));
                $OPrescrire->setTinCode($request->request->get("individu"));
                $OPrescrire->setDosCode($request->request->get("dosage"));

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($OPrescrire);
                $entityManager->flush();

                return $this->redirectToRoute('prescrire_index', [], Response::HTTP_SEE_OTHER);

            }
        }

        return $this->renderForm('prescrire/edit.html.twig', [
//            'prescrire' => $prescrire,
//            'form' => $form,
            'medicaments' => $listeMedicament,
            'individus' => $listeTY,
            'dosages' => $listeDosage,
            'default' => $default,
        ]);
    }

    #[Route('/{id}', name: 'prescrire_delete', methods: ['POST'])]
    public function delete(Request $request, Prescrire $prescrire): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$prescrire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($prescrire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('prescrire_index', [], Response::HTTP_SEE_OTHER);
    }
}