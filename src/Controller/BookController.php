<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Entity\Comment;
use App\Entity\BookLike;
use App\Form\CommentType;
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
    public function newBook(Request $request, CategoryRepository $categoriesRepo): Response
    {
        $categories = $categoriesRepo->findAll();
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
        
        $this->em->persist($book);
        $this->em->flush();

        }

        return $this->render('book/newbook.html.twig', [
            'form' => $form->createView(),
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/book/{id}", name="book_show")
     * @return Response
     */
    public function Book(Request $request, Book $book, CategoryRepository $categoriesRepo): Response
    {
        $categories = $categoriesRepo->findAll();
        $pourcent = round(($book->getreducePrice() / $book->getNormalPrice()) * 100);
        $user = $this->getUser();


        // if ($book->getSlug() !== $slug)
        // {
        //     return $this->redirectToRoute('book_show', [
        //         'id' => $book->getId(),
        //         'slug' => $book->getSlug()
        //     ], 301); 
        // }

        // $book = $this->$book->getId();

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $comment->setUser($user);
            $comment->setBook($book);
            $comment->setDate(new \DateTime());
            
            $this->em->persist($comment);
            $this->em->flush();
        }

        return $this->render('book/book_show.html.twig', [
            'book'=> $book,
            'comment' => $comment,
            'pourcent' => $pourcent,
            'comment_form' => $form->createView(),
            'categories' => $categories
        ]);
    }
}
