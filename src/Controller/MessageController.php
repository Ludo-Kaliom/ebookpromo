<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Message;
use App\Form\AnswerType;
use App\Repository\AnswerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessageController extends AbstractController
{
    #[Route('/message/{slug}-{id}', name: 'app_message_show', requirements:['slug'=>"[a-z0-9\-]*"])]
    public function index(Message $message, string $slug, AnswerRepository $answerRepository, EntityManagerInterface $em, Request $request): Response
    {
        if ($message->getSlug() !== $slug) {
            return $this->redirectToRoute('app_message_show', [
                'id' => $message->getId(),
                'slug' => $message->getSlug()
            ], 301);
        }
        $id = $message->getId();
        $answers = $answerRepository->findBy(
            array(
               'firstMessage' => $id
            ),
            array('id' => 'ASC')
        );

        $answer = new Answer();
        $formAnswer = $this->createForm(AnswerType::class, $answer);
        $formAnswer->handleRequest($request);
        if ($formAnswer->isSubmitted() && $formAnswer->isValid()) {
            $answer->setCreatedAt(new \DateTime());
            $answer->setUsername($this->getUser());
            $answer->setFirstMessage($message);
            $em->persist($answer);
            $em->flush();
            $this->addFlash('success', 'Votre message a bien été envoyé à la modération');
            return $this->redirectToRoute('app_message_show', ['id' => $message->getId(), 'slug' => $message->getSlug()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('message/message_show.html.twig', [
            'message' => $message,
            'answers' => $answers,
            'formAnswer'=> $formAnswer->createView(),
        ]);
    }
}
