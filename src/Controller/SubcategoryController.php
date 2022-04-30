<?php

namespace App\Controller;

use App\Entity\Subcategory;
use App\Repository\BookRepository;
use App\Repository\SubcategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SubcategoryController extends AbstractController
{
    #[Route('/subcategory', name: 'subcategory')]
    public function index(SubcategoryRepository $subcategoryRepository): Response
    {
        $subcategories = $subcategoryRepository->findByStatus(true);

        return $this->render('subcategory/subcategory.html.twig', [
            'subcategories' => $subcategories,
        ]);
    }

    /**
     * @Route("/subcategory/{slug}-{id}", name="subcategory_show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function Subcategory(BookRepository $bookRepository, Subcategory $subcategory, string $slug, PaginatorInterface $paginator, Request $request): Response
    {

        if ($subcategory->getSlug() !== $slug)
        {
            return $this->redirectToRoute('subcategory_show', [
                'id' => $subcategory->getId(),
                'slug' => $subcategory->getSlug()
            ], 301); 
        }

        $id = $subcategory->getId();

        $data = $subcategory->getSubcategorybook($id);
        $books = $paginator->paginate($data, $request->query->getInt('page', 1), 11);   

        return $this->render('subcategory/subcategory_show.html.twig', [
            'subcategory' => $subcategory,
            'books' => $books,
        ]);
    }
}
