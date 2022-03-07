<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\TypeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article/{slug}-{id}", name="article_show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function index(Article $article, TypeRepository $typeRepository, string $slug): Response
    {

        $types = $typeRepository->findByStatus(true);

        if ($article->getSlug() !== $slug)
        {
            return $this->redirectToRoute('article_show', [
                'id' => $article->getId(),
                'slug' => $article->getSlug()
            ], 301); 
        }

        return $this->render('article/article_show.html.twig', [
            'controller_name' => 'ArticleController',
            'article' => $article,
            'types' => $types
        ]);
    }
}
