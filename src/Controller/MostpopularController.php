<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MostpopularController extends AbstractController
{
    #[Route('/mostpopular', name: 'mostpopular')]
    public function mostpopular(BookRepository $bookRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $data = $bookRepository->findMostPopular(true);
        $paginates = $paginator->paginate($data, $request->query->getInt('page', 1), 12);
        
        return $this->render('mostpopular/mostpopular.html.twig', [
            'books' => $paginates,
        ]);
    }
}
