<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BestdiscountsController extends AbstractController
{
    #[Route('/bestdiscounts', name: 'bestdiscounts')]
    public function bestsdiscounts(BookRepository $bookRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $books = $paginator->paginate($bookRepository->findBestDiscounts(true), $request->query->getInt('page', 1), 12);

        return $this->render('bestdiscounts/bestdiscounts.html.twig', [
            'controller_name' => 'BestdiscountsController',
            'books' => $books,
        ]);
    }
}