<?php

namespace App\Controller\Admin;

use App\Entity\Subcategory;
use App\Form\Subcategory1Type;
use App\Repository\SubcategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/subcategory')]
class SubcategoryAdminController extends AbstractController
{
    #[Route('/', name: 'subcategory_index', methods: ['GET'])]
    public function index(SubcategoryRepository $subcategoryRepository): Response
    {
        return $this->render('admin/subcategory/index.html.twig', [
            'subcategories' => $subcategoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'subcategory_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $subcategory = new Subcategory();
        $form = $this->createForm(Subcategory1Type::class, $subcategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($subcategory);
            $entityManager->flush();

            return $this->redirectToRoute('subcategory_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/subcategory/new.html.twig', [
            'subcategory' => $subcategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'subcategory_show', methods: ['GET'])]
    public function show(Subcategory $subcategory): Response
    {
        return $this->render('admin/subcategory/show.html.twig', [
            'subcategory' => $subcategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'subcategory_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Subcategory $subcategory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Subcategory1Type::class, $subcategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('subcategory_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/subcategory/edit.html.twig', [
            'subcategory' => $subcategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'subcategory_delete', methods: ['POST'])]
    public function delete(Request $request, Subcategory $subcategory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subcategory->getId(), $request->request->get('_token'))) {
            $entityManager->remove($subcategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('subcategory_index', [], Response::HTTP_SEE_OTHER);
    }
}
