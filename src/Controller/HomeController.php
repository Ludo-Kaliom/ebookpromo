<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Category;
use App\Repository\BookRepository;
use App\Repository\TypeRepository;
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
    public function index(BookRepository $bookRepo, TypeRepository $typeRepository): Response
    {
        $books = $bookRepo->findAll();
        $types = $typeRepository->findAll();


        return $this->render('home/index.html.twig', [
            'books' => $books,
            'types' => $types
        ]);
    }
}
