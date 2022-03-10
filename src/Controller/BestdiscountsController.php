<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Repository\TypeRepository;
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

        $data = $bookRepository->findBestDiscounts(true);
        $paginates = $paginator->paginate($data, $request->query->getInt('page', 1), 11);

        return $this->render('bestdiscounts/bestdiscounts.html.twig', [
            'controller_name' => 'BestdiscountsController',
            'books' => $data,
            'paginates' => $paginates,
        ]);
    }
}
