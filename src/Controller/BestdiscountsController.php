<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BestdiscountsController extends AbstractController
{
    #[Route('/bestdiscounts', name: 'bestdiscounts')]
    public function bestsdiscounts(CategoryRepository $categoryRepository, BookRepository $bookRepository): Response
    {

        $categories = $categoryRepository->findAll();

        $books = $bookRepository->findBestDiscounts();

        return $this->render('bestdiscounts/bestdiscounts.html.twig', [
            'controller_name' => 'BestdiscountsController',
            'categories' => $categories,
            'books' => $books,
        ]);
    }
}
