<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                // encode the plain password
                if ($form->get('plainPassword') !== null){
                $user->setPassword(
                $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
                }
                if ($user->getAvatar() !== null) {
                    $file = $form->get('avatar')->getData();
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
                }
                $user->setRegistrationdate(new \DateTime());
                $user->setUpdated(new \DateTime());
                $user->setStatus(true);
                $entityManager->persist($user);
                $entityManager->flush();
                // do anything else you need here, like send an email
                return $this->redirectToRoute('home');
            }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}