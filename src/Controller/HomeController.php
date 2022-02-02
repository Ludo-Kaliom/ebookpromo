<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param BookRepository $repository
     */
    public function index(BookRepository $repository): Response
    {
        $books = $repository->findAll();

        return $this->render('home/index.html.twig', [
            'books' => $books
        ]);
    }
}
