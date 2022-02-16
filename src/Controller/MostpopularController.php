<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Repository\TypeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MostpopularController extends AbstractController
{
    #[Route('/mostpopular', name: 'mostpopular')]
    public function mostpopular(TypeRepository $typeRepository, BookRepository $bookRepository): Response
    {
        $types = $typeRepository->findAll();
        $books = $bookRepository->findMostPopular();
        

        return $this->render('mostpopular/mostpopular.html.twig', [
            'controller_name' => 'MostpopularController',
            'types' => $types,
            'books' => $books

        ]);
    }
}
