<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Type;
use Doctrine\ORM\EntityManager;
use App\Repository\BookRepository;
use App\Repository\TypeRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TypeController extends AbstractController
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;


    #[Route('/type', name: 'type')]
    public function type(TypeRepository $typeRepository, CategoryRepository $categoryRepository): Response
    {
        $types = $typeRepository->findAll();
        $categories = $categoryRepository->findAll();

        return $this->render('type/type.html.twig', [
            'controller_name' => 'TypeController',
            'types' => $types,
            'categories' => $categories,
        ]);
    }

    #[Route('/type/{id}', name: 'type_show')]
    public function show_type(Type $type, CategoryRepository $categoryRepository): Response
    {
        $id = $type->getId();
        $books = $type->getBooks($id);

        $categories = $categoryRepository->findAll();

        return $this->render('type/type_show.html.twig', [
            'controller_name' => 'TypeController',
            'categories' => $categories,
            'books' => $books,
        ]);
    }
}
