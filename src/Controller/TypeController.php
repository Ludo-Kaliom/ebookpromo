<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Type;
use Doctrine\ORM\EntityManager;
use App\Repository\BookRepository;
use App\Repository\TypeRepository;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
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
    public function type(TypeRepository $typeRepository): Response
    {
        $types = $typeRepository->findAll();

        return $this->render('type/type.html.twig', [
            'controller_name' => 'TypeController',
            'types' => $types,
        ]);
    }

    /**
     * @Route("/type/{slug}-{id}", name="type_show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show_type(Type $type, TypeRepository $typeRepository, string $slug, PaginatorInterface $paginator, Request $request): Response
    {
        if ($type->getSlug() !== $slug)
        {
            return $this->redirectToRoute('type_show', [
                'id' => $type->getId(),
                'slug' => $type->getSlug()
            ], 301); 
        }

        $types = $typeRepository->findAll();

        $id = $type->getId();
        $data = $type->getBooks($id);
        $books = $paginator->paginate($data, $request->query->getInt('page', 1), 11);


        return $this->render('type/type_show.html.twig', [
            'controller_name' => 'TypeController',
            'types' => $types,
            'books' => $books,
            'type' => $type
        ]);
    }
}
