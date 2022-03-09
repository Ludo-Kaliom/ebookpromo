<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Category;
use App\Repository\BookRepository;
use App\Repository\TypeRepository;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param BookRepository $repository
     */
    public function index(BookRepository $bookRepo, TypeRepository $typeRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $data = $bookRepo->findByStatus(true);
        $types = $typeRepository->findByStatus(true);

        $paginates = $paginator->paginate($data, $request->query->getInt('page', 1), 11);

        return $this->render('home/index.html.twig', [
            'books' => $data,
            'types' => $types,
            'paginates' => $paginates,
        ]);
    }
}
