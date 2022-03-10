<?php

namespace App\Controller;

use App\Entity\Type;
use App\Repository\BookRepository;
use App\Repository\TypeRepository;
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
        $types = $typeRepository->findByStatus(true);

        return $this->render('type/type.html.twig', [
            'controller_name' => 'TypeController',
            'types' => $types,
        ]);
    }

    /**
     * @Route("/type/{slug}-{id}", name="type_show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show_type(Type $type, TypeRepository $typeRepository, string $slug, PaginatorInterface $paginator, Request $request, BookRepository $bookRepository): Response
    {
        if ($type->getSlug() !== $slug)
        {
            return $this->redirectToRoute('type_show', [
                'id' => $type->getId(),
                'slug' => $type->getSlug()
            ], 301); 
        }

        $types = $typeRepository->findByStatus(true);

        $id = $type->getId();
        $data = $type->getBooks($id);

        $paginates = $paginator->paginate($data, $request->query->getInt('page', 1), 11);
        
        $books = $bookRepository->findBy(array
            ('type' => $id,
            'status' => true
            ), array('status' => 'ASC')
        );  

        return $this->render('type/type_show.html.twig', [
            'controller_name' => 'TypeController',
            'types' => $types,
            'paginates' => $paginates,
            'type' => $type,
            'books' => $books
        ]);
    }
}
