<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\BookRepository;
use App\Repository\TypeRepository;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('/category/', name: 'category')]
    public function show_categories(CategoryRepository $categoryRepository, TypeRepository $typeRepository): Response
    {
        $categories = $categoryRepository->findByStatus(true);

        $types = $typeRepository->findByStatus(true);

        return $this->render('category/categories.html.twig', [
            'controller_name' => 'CategoryController',
            'categories' => $categories,
            'types' => $types
        ]);
    }

    /**
     * @Route("/category/{slug}-{id}", name="category_show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function Category(BookRepository $bookRepository, Category $category, TypeRepository $typeRepository, string $slug, PaginatorInterface $paginator, Request $request): Response
    {

        if ($category->getSlug() !== $slug)
        {
            return $this->redirectToRoute('book_show', [
                'id' => $category->getId(),
                'slug' => $category->getSlug()
            ], 301); 
        }

        $id = $category->getId();
        $types = $typeRepository->findByStatus(true);

        $data = $category->getBooks($id);
        $paginates = $paginator->paginate($data, $request->query->getInt('page', 1), 11);

        $books = $bookRepository->findBy(array
            ('category' => $id,
            'status' => true
            ), array('status' => 'ASC')
        );

        return $this->render('category/category_show.html.twig', [
            'paginates' => $paginates,
            'category' => $category,
            'types' => $types,
            'books' => $books
        ]);
    }

}
