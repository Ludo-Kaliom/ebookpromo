<?php

namespace App\Controller\Admin;

use App\Entity\Type;
use App\Form\Type1Type;
use App\Repository\TypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/type')]
class TypeAdminController extends AbstractController
{
    #[Route('/', name: 'type_index', methods: ['GET'])]
    public function index(TypeRepository $typeRepository): Response
    {
        return $this->render('admin/type/index.html.twig', [
            'types' => $typeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'type_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $type = new Type();
        $form = $this->createForm(Type1Type::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($type);
            $entityManager->flush();

            return $this->redirectToRoute('type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/type/new.html.twig', [
            'type' => $type,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'type_show', methods: ['GET'])]
    public function show(Type $type): Response
    {
        return $this->render('admin/type/show.html.twig', [
            'type' => $type,
        ]);
    }

    #[Route('/{id}/edit', name: 'type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Type $type, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Type1Type::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/type/edit.html.twig', [
            'type' => $type,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'type_delete', methods: ['POST'])]
    public function delete(Request $request, Type $type, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$type->getId(), $request->request->get('_token'))) {
            $entityManager->remove($type);
            $entityManager->flush();
        }

        return $this->redirectToRoute('type_index', [], Response::HTTP_SEE_OTHER);
    }
}
