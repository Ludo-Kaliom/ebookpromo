<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Repository\TypeRepository;
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
    public function index(BookRepository $bookRepo, PaginatorInterface $paginator, Request $request): Response
    {
        $data = $bookRepo->findByStatus(true);

        $paginates = $paginator->paginate($data, $request->query->getInt('page', 1), 11);

        return $this->render('home/index.html.twig', [
            'books' => $data,
            'paginates' => $paginates,
        ]);
    }

    public function header(BookRepository $bookRepo, TypeRepository $typeRepository): Response
    {
        $data = $bookRepo->findByStatus(true);
        $types = $typeRepository->findByStatus(true);

        return $this->render('partials/_header.html.twig', [
            'books' => $data,
            'types' => $types
        ]);
    }
}
