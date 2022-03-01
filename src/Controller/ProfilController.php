<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\TypeRepository;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilController extends AbstractController
{
    #[Route('/user/account', name: 'account')]
    public function index(TypeRepository $typeRepository, UserRepository $userRepository): Response
    {
        $types = $typeRepository->findByStatus(true);

        return $this->render('user/account.html.twig', [
            'controller_name' => 'ProfilController',
            'types' => $types,
            'user' => $userRepository
        ]);
    }
}
