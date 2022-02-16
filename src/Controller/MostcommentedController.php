<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\BookRepository;
use App\Repository\TypeRepository;
use App\Repository\CommentRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MostcommentedController extends AbstractController
{
    #[Route('/mostcommented', name: 'mostcommented')]
    public function mostcommented(TypeRepository $typeRepository, BookRepository $bookRepository): Response
    {
        $types = $typeRepository->findAll();
        $books = $bookRepository->findMostCommented();

        return $this->render('mostcommented/mostcommented.html.twig', [
            'controller_name' => 'MostcommentedController',
            'types' => $types,
            'books' => $books,
        ]);
    }
}