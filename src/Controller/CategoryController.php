<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('/category/', name: 'category')]
    public function show_categories(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findByStatus(true);

        return $this->render('category/categories.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/category/{slug}-{id}", name="category_show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function Category(BookRepository $bookRepository, Category $category, string $slug, PaginatorInterface $paginator, Request $request): Response
    {

        if ($category->getSlug() !== $slug)
        {
            return $this->redirectToRoute('book_show', [
                'id' => $category->getId(),
                'slug' => $category->getSlug()
            ], 301); 
        }

        $id = $category->getId();

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
            'books' => $books
        ]);
    }

}
