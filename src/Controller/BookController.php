<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Entity\Comment;
use App\Form\CommentType;
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
     * @Route("/addbook", name="addbook")
     */
    public function addBook(Request $request): Response
    {
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

        return $this->render('book/addbook.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/book/{slug}-{id}", name="book_show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function Book(Request $request, Book $book, string $slug): Response
    {
        $pourcent = round(($book->getreducePrice() / $book->getNormalPrice()) * 100);
        $user = $this->getUser();

        if ($book->getSlug() !== $slug)
        {
            return $this->redirectToRoute('book_show', [
                'id' => $book->getId(),
                'slug' => $book->getSlug()
            ], 301); 
        }

        $book = $this->$book->getId();

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $comment->setUser($user);
            $comment->setBook($book);
            
            $this->em->persist($comment);
            $this->em->flush();
        }

        return $this->render('book/book_show.html.twig', [
            'book'=> $book,
            'pourcent' => $pourcent,
            'comment_form' => $form->createView(),
        ]);
    }
}
