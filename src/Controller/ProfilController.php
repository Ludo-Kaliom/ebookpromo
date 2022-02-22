<?php

namespace App\Controller;

use App\Repository\TypeRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilController extends AbstractController
{
    #[Route('/user/account', name: 'account')]
    public function index(TypeRepository $typeRepository): Response
    {
        $types = $typeRepository->findByStatus(true);

        return $this->render('user/account.html.twig', [
            'controller_name' => 'ProfilController',
            'types' => $types
        ]);
    }
}
