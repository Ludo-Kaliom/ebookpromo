<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MostpopularController extends AbstractController
{
    #[Route('/mostpopular', name: 'mostpopular')]
    public function mostpopular(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('mostpopular/mostpopular.html.twig', [
            'controller_name' => 'MostpopularController',
            'categories' => $categories,

        ]);
    }
}
