<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Category;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param BookRepository $repository
     */
    public function index(BookRepository $bookRepo, CategoryRepository $categoriesRepo): Response
    {
        $books = $bookRepo->findAll();
        $categories = $categoriesRepo->findAll();


        return $this->render('home/index.html.twig', [
            'books' => $books,
            'categories' => $categories
        ]);
    }
}
