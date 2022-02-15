<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Entity\Comment;
use App\Entity\BookLike;
use App\Form\CommentType;
use App\Repository\TypeRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


class BookController extends AbstractController
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

     /**
     * @Route("book/newbook", name="newbook")
     */
    public function newBook(Request $request, TypeRepository $typeRepository): Response
    {
        $types = $typeRepository->findAll();
        $user = $this->getUser();
        $book = new Book();
        
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if ($book->getCover() !== null) {
                $file = $form->get('cover')->getData();
                $fileName =  uniqid(). '.' .$file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('images_directory'),
                        $fileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }

                $book->setCover($fileName);
            }
        
        $book->setUser($user);

        $total = round(($book->getreducePrice() / $book->getNormalPrice()) * 100);
        
        $book->setTotalprice($total);
        
        $this->em->persist($book);
        $this->em->flush();

        }

        return $this->render('book/newbook.html.twig', [
            'form' => $form->createView(),
            'types' => $types
        ]);
    }

    /**
     * @Route("/book/{slug}-{id}", name="book_show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function Book(Request $request, Book $book, TypeRepository $typeRepository, string $slug): Response
    {
        $types = $typeRepository->findAll();
        $pourcent = round(($book->getreducePrice() / $book->getNormalPrice()) * 100);
        $user = $this->getUser();
        $nbcomments = $book->getNbcomments();

        if ($book->getSlug() !== $slug)
        {
            return $this->redirectToRoute('book_show', [
                'id' => $book->getId(),
                'slug' => $book->getSlug()
            ], 301); 
        }

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $comment->setUser($user);
            $comment->setBook($book);
            $comment->setDate(new \DateTime());
            
            $this->em->persist($comment);
            $this->em->flush();

            $totalnbcomments = $nbcomments +1;

            $book = $book->setNbcomments($totalnbcomments);

            $this->em->persist($book);
            $this->em->flush();
        }

        return $this->render('book/book_show.html.twig', [
            'book'=> $book,
            'comment' => $comment,
            'pourcent' => $pourcent,
            'comment_form' => $form->createView(),
            'types' => $types
        ]);
    }
}
