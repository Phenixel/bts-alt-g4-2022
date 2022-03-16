<?php

namespace App\Controller;

use App\Entity\TypeIndividu;
use App\Form\TypeIndividuType;
use App\Repository\TypeIndividuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/type/individu')]
class TypeIndividuController extends AbstractController
{
    #[Route('/', name: 'type_individu_index', methods: ['GET'])]
    public function index(TypeIndividuRepository $typeIndividuRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

//        dd($typeIndividuRepository->findAll());

        return $this->render('type_individu/index.html.twig', [
            'type_individus' => $typeIndividuRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'type_individu_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $typeIndividu = new TypeIndividu();

        if ($request->request->get("typeindividu")) {
//            dd($request->request);
            $typeIndividu = new TypeIndividu();
            $typeIndividu->setTinLibelle($request->request->get("typeindividu")["tin_libelle"]);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($typeIndividu);
            $entityManager->flush();

            return $this->redirectToRoute('type_individu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_individu/new.html.twig', [
            'type_individu' => $typeIndividu,
        ]);
    }

    #[Route('/{id}', name: 'type_individu_show', methods: ['GET'])]
    public function show(TypeIndividu $typeIndividu): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->render('type_individu/show.html.twig', [
            'type_individu' => $typeIndividu,
        ]);
    }

    #[Route('/{id}/edit', name: 'type_individu_edit', methods: ['GET','POST'])]
    public function edit(Request $request, TypeIndividu $typeIndividu): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(TypeIndividuType::class, $typeIndividu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('type_individu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_individu/edit.html.twig', [
            'type_individu' => $typeIndividu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'type_individu_delete', methods: ['POST'])]
    public function delete(Request $request, TypeIndividu $typeIndividu): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$typeIndividu->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($typeIndividu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('type_individu_index', [], Response::HTTP_SEE_OTHER);
    }
}
