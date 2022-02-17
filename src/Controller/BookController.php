<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\BookLike;
use App\Form\BookType;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Form\BookLikeType;
use App\Repository\BookLikeRepository;
use App\Repository\BookRepository;
use App\Repository\CommentRepository;
use App\Repository\TypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ObjectManager;
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
    public function Book(Request $request, Book $book, TypeRepository $typeRepository, string $slug, CommentRepository $commentRepository): Response
    {
        if ($book->getSlug() !== $slug)
        {
            return $this->redirectToRoute('book_show', [
                'id' => $book->getId(),
                'slug' => $book->getSlug()
            ], 301); 
        }

        $types = $typeRepository->findAll();
        $pourcent = round(($book->getreducePrice() / $book->getNormalPrice()) * 100);
        $user = $this->getUser();
       
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $comment->setUser($user);
            $comment->setBook($book);
            $comment->setDate(new \DateTime());
            
            $this->em->persist($comment);
            $this->em->flush();

            $totalnbcomments = $commentRepository->count(['book' => $book]);

            $book->setNbcomments($totalnbcomments);

            $this->em->persist($book);
            $this->em->flush();

        }

        return $this->render('book/book_show.html.twig', [
            'book'=> $book,
            'comment' => $comment,
            'pourcent' => $pourcent,
            'comment_form' => $form->createView(),
            'types' => $types, 
        ]);
    }

    /**
     * Permet de liker ou disliker un livre
     *
     * @Route("/book/{slug}-{id}/like", name="book_like", requirements={"slug": "[a-z0-9\-]*"})
     * 
     * @param Book $book
     * @param ObjectManager $manager
     * @param BookLikeRepository $booklikeRepository
     * @return Response
     */
    public function like(Book $book, BookLikeRepository $booklikeRepository, string $slug): Response 
    {
        if ($book->getSlug() !== $slug) {
            return $this->redirectToRoute('book_show', [
                'id' => $book->getId(),
                'slug' => $book->getSlug()
            ], 301);
        }

        $user = $this->getUser();
        
        if(!$user) return $this->json([
            'code' => 403,
            'message' => 'Unauthorized'
        ], 403);

        if($book->isLikedByUser($user)){
            $booklike = $booklikeRepository->findOneBy([
                'book' => $book,
                'user' => $user
            ]);

            $this->em->remove($booklike);
            $this->em->flush();

            $nblikes = $booklikeRepository->count(['book' => $book]);

            $book->setNblikes($nblikes);

            $this->em->persist($book);
            $this->em->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Like bien supprimé',
                'likes' => $booklikeRepository->count(['book' => $book])
            ], 200);
        }

        $booklike = new BookLike();
        $booklike->setBook($book)
                 ->setUser($user);

        $this->em->persist($booklike);
        $this->em->flush();

        $nblikes = $booklikeRepository->count(['book' => $book]);

        $book->setNblikes($nblikes);

        $this->em->persist($book);
        $this->em->flush();

        return $this->json([
            'code' => 200,
            'message' => 'Like bien ajouté',
            'likes' => $booklikeRepository->count(['book' => $book])
        ], 200);
    }

}
