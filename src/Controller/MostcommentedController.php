<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MostcommentedController extends AbstractController
{
    #[Route('/mostcommented', name: 'mostcommented')]
    public function mostcommented(BookRepository $bookRepository, PaginatorInterface $paginator, Request $request): Response
    {

        $data = $bookRepository->findBy(
            array(
                'status' => true,
                'nbcomments' => true,
            ),
            array('nbcomments' => 'ASC')
        );
        $paginates = $paginator->paginate($data, $request->query->getInt('page', 1), 11);

        return $this->render('mostcommented/mostcommented.html.twig', [
            'books' => $data,
            'paginates' => $paginates
        ]);
    }
}
