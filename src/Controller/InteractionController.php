<?php

namespace App\Controller;

use App\Entity\Interaction;
use App\Entity\Medicament;
use App\Form\InteractionType;
use App\Repository\InteractionRepository;
use App\Repository\MedicamentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/interaction')]
class InteractionController extends AbstractController
{
    #[Route('/', name: 'interaction_index', methods: ['GET'])]
    public function index(InteractionRepository $interactionRepository): Response
    {
        return $this->render('interaction/index.html.twig', [
            'interactions' => $interactionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'interaction_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, MedicamentRepository $medicamentRepository, InteractionRepository $interactionRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $listeMedicament = $medicamentRepository->findAll();
//        $listeMedicamentDispo = $interactionRepository->getInterDispo();
        $interaction = new Interaction();

//        dd($request->request);

//        dd($request->request->get("medicament-perturbateur"));
        if ($request->request->has("medicament-perturbateur")) {
            $interaction = $interactionRepository->findUneInteraction(
                $request->request->get("medicament-perturbateur"),
                $request->request->get("medicament-pertube")
            );
//            dd($request->request->get("medicament-perturbateur"));

            if (empty($interaction) == false) {
                echo ("<script>alert('Cette Interraction existe déjà.');</script>");
            }elseif ($request->request->get("medicament-pertube") == $request->request->get("medicament-perturbateur")){
                echo ("<script>alert('Veuillez choisir deux médicaments différents.');</script>");
            }else{
                $interaction = new Interaction();
                $interaction->setMEDMEDPERTURBE($request->request->get("medicament-pertube"));
                $interaction->setMEDPERTURBATEUR($request->request->get("medicament-perturbateur"));

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($interaction);
                $entityManager->flush();

//            dd($request->request);

//            return $this->redirectToRoute('interaction_new', [], Response::HTTP_SEE_OTHER);
                return $this->redirect("/", Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('interaction/new.html.twig', [
            'interaction' => $interaction,
            'medicaments' => $listeMedicament,
//            'mediDispo' => $listeMedicamentDispo
        ]);
    }

    #[Route('/{id}', name: 'interaction_show', methods: ['GET'])]
    public function show(Interaction $interaction): Response
    {
        return $this->render('interaction/show.html.twig', [
            'interaction' => $interaction,
        ]);
    }

    #[Route('/{id}/edit', name: 'interaction_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Interaction $interaction, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InteractionType::class, $interaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('interaction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('interaction/edit.html.twig', [
            'interaction' => $interaction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'interaction_delete', methods: ['POST'])]
    public function delete(Request $request, Interaction $interaction, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$interaction->getId(), $request->request->get('_token'))) {
            $entityManager->remove($interaction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('interaction_index', [], Response::HTTP_SEE_OTHER);
    }
}
