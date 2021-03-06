<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Message;
use App\Form\MessageType;
use App\Form\UserMailType;
use App\Form\UserAvatarType;
use App\Form\UserPasswordType;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfilController extends AbstractController
{
    #[Route('/user/account', name: 'account', methods: ['GET', 'POST'])]
    public function index(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $userPasswordHasher, MessageRepository $messageRepository): Response
    {
        $user = new User();
        $formavatar = $this->createForm(UserAvatarType::class, $user);
        $user = $this->getUser();
        //Avatar
        $formavatar->handleRequest($request);
        if ($formavatar->isSubmitted() && $formavatar->isValid()) {
            $file = $formavatar->get('avatar')->getData();
            $fileName =  uniqid(). '.' .$file->guessExtension();
            try {
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                return new Response($e->getMessage());
            }
            $user->setAvatar($fileName);
            $user->setUpdated(new \DateTime());
            $em->flush();
            $this->addFlash('success', 'Votre avatar a bien été modifié');
            return $this->redirectToRoute('account', [], Response::HTTP_SEE_OTHER);
        }
        //Mail
        $formmail = $this->createForm(UserMailType::class, $user);
        $user = $this->getUser();
        $formmail->handleRequest($request);
        if ($formmail->isSubmitted() && $formmail->isValid()) {
            $user->setUpdated(new \DateTime());
            $em->flush();
            $this->addFlash('success', 'Votre email a bien été modifié');
            return $this->redirectToRoute('account', [], Response::HTTP_SEE_OTHER);
        }
        //Password
        $formpassword = $this->createForm(UserPasswordType::class, $user);
        $user = $this->getUser();
        $formpassword->handleRequest($request);
        if ($formpassword->isSubmitted() && $formpassword->isValid()) {
            if ($formpassword->get('plainPassword') !== null) {
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                            $user,
                            $formpassword->get('plainPassword')->getData()
                        )
                );
            }
            $user->setUpdated(new \DateTime());
            $em->flush();
            $this->addFlash('success', 'Votre mot de passe a bien été modifié');
            return $this->redirectToRoute('account', [], Response::HTTP_SEE_OTHER);
        }
        //Message à la modération
        $message = new Message();
        $formMessage = $this->createForm(MessageType::class, $message);
        $formMessage->handleRequest($request);
        if ($formMessage->isSubmitted() && $formMessage->isValid()) {
            $message->setCreatedAt(new \DateTime());
            $message->setUsername($this->getUser());
            $message->setStatus(true);
            $em->persist($message);
            $em->flush();
            $this->addFlash('success', 'Votre message a bien été envoyé à la modération');
            return $this->redirectToRoute('account', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/account.html.twig', [
            'formavatar' => $formavatar->createView(),
            'formmail' => $formmail->createView(),
            'formpassword' => $formpassword->createView(),
            'formMessage' => $formMessage->createView(),
            'messages' => $messageRepository->findMessages($this->getUser()),
        ]);
    }
}
