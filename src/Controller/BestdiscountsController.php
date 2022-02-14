<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Repository\TypeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BestdiscountsController extends AbstractController
{
    #[Route('/bestdiscounts', name: 'bestdiscounts')]
    public function bestsdiscounts(TypeRepository $typeRepository, BookRepository $bookRepository): Response
    {

        $types = $typeRepository->findAll();

        $books = $bookRepository->findBestDiscounts();

        return $this->render('bestdiscounts/bestdiscounts.html.twig', [
            'controller_name' => 'BestdiscountsController',
            'types' => $types,
            'books' => $books,
        ]);
    }
}
