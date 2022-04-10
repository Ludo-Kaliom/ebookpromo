<?php

namespace App\Controller\Admin;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index(BookRepository $bookRepository): Response
    {
        return $this->render('admin/index.html.twig', [
            'books' => $bookRepository->findBy(
                array(
                    'status'=> FALSE
                ), 
                 array(
                     'id' => 'DESC')
              ),
        ]);
    }
}
