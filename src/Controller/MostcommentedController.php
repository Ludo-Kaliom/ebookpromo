<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\BookRepository;
use App\Repository\TypeRepository;
use App\Repository\CommentRepository;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MostcommentedController extends AbstractController
{
    #[Route('/mostcommented', name: 'mostcommented')]
    public function mostcommented(TypeRepository $typeRepository, BookRepository $bookRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $types = $typeRepository->findByStatus(true);

        $data = $bookRepository->findMostCommented(true);
        $books = $paginator->paginate($data, $request->query->getInt('page', 1), 11);

        return $this->render('mostcommented/mostcommented.html.twig', [
            'controller_name' => 'MostcommentedController',
            'types' => $types,
            'books' => $books,
        ]);
    }
}