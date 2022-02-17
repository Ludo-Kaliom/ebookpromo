<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Repository\TypeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MostpopularController extends AbstractController
{
    #[Route('/mostpopular', name: 'mostpopular')]
    public function mostpopular(TypeRepository $typeRepository, BookRepository $bookRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $types = $typeRepository->findAll();

        $data = $bookRepository->findMostPopular();
        $books = $paginator->paginate($data, $request->query->getInt('page', 1), 11);
        
        return $this->render('mostpopular/mostpopular.html.twig', [
            'controller_name' => 'MostpopularController',
            'types' => $types,
            'books' => $books

        ]);
    }
}
