<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Answer;
use App\Entity\Message;
use App\Form\AnswerType;
use App\Form\Message1Type;
use App\Repository\AnswerRepository;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/message')]
class MessageAdminController extends AbstractController
{
    #[Route('/', name: 'message_index', methods: ['GET'])]
    public function index(MessageRepository $messageRepository): Response
    {
        return $this->render('admin/message/index.html.twig', [
            'messages' => $messageRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'message_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $user = new User();
        $user = $this->getUser();
        $message = new Message();
        $form = $this->createForm(Message1Type::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setCreatedAt(new \DateTime());
            $message->setAdminname($user);
            $em->persist($message);
            $em->flush();
            return $this->redirectToRoute('message_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/message/new.html.twig', [
            'message' => $message,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'message_show', methods: ['GET', 'POST'])]
    public function show(Message $message, AnswerRepository $answerRepository, Request $request, EntityManagerInterface $em): Response
    {
        
        $answers = $answerRepository->findBy(
            array(
               'firstMessage' => $message->getId()
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
            $this->addFlash('success', 'Votre message a bien été envoyé');
            return $this->redirectToRoute('message_show', ['id' => $message->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/message/show.html.twig', [
            'message' => $message,
            'answers' => $answers,
            'formAnswer'=> $formAnswer->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'message_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Message $message, MessageRepository $messageRepository): Response
    {
        $form = $this->createForm(Message1Type::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $messageRepository->add($message);
            return $this->redirectToRoute('message_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/message/edit.html.twig', [
            'message' => $message,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'message_delete', methods: ['POST'])]
    public function delete(Request $request, Message $message, MessageRepository $messageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
            $messageRepository->remove($message);
        }

        return $this->redirectToRoute('message_index', [], Response::HTTP_SEE_OTHER);
    }
}
