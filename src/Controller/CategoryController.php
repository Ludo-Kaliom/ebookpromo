<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('/category/', name: 'categories')]
    public function show_categories(CategoryRepository $categoryRepository): Response
    {

        $categories = $categoryRepository->findAll();

        return $this->render('category/categories.html.twig', [
            'controller_name' => 'CategoryController',
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/category/{id}", name="category_show")
     * @return Response
     */
    public function Category(Request $request, CategoryRepository $categoriesRepo, CategoryRepository $bookRepo): Response
    {
        $books = $bookRepo->findAll();
        $categories = $categoriesRepo->findAll();

        return $this->render('category/category_show.html.twig', [
            'books' => $books,
            'categories' => $categories
        ]);
    }

}
