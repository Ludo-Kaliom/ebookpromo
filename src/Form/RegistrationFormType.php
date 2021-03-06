<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Votre adresse email'
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => "Conditions d'utilisation",
                'mapped' => false,
                'label_attr' => [
                    'class' => 'checkbox-switch',
                    ],
                'constraints' => [
                    new IsTrue([
                        'message' => "Pour vous inscrire, vous devez approuver nos conditions d'utilisation",
                    ]),
                ],
            ])
            ->add('subscription', CheckboxType::class, [
                'label' => "S'abonner aux notifications",
                'required'   => false,
                'label_attr' => [
                'class' => 'checkbox-switch',
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'label' => 'Mot de passe',
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'placeholder' => "Votre mot de passe",
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez un mot de passe',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit faire au minimum {{ limit }} caract??res',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'first_options'  => ['label' => 'Votre mot de passe'],
                'second_options' => ['label' => 'Rep??tez le mot de passe'],
            ])
            ->add('username', TextType::class, [
                'label' => "Nom d'utilisateur",
                'attr' => [
                    'placeholder' => "Mon nom d'utilisateur"
                ],
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'minMessage' => "Votre nom d'utilisateur doit contenir au moins {{ limit }} caract??res.",
                    ]),
                    new NotBlank([
                        'message' => "Votre nom d'utilisateur ne peut pas ??tre vide",
                    ]),
                ],
            ])
            ->add('avatar', FileType::class, [
                'label' => 'Avatar (.png, taille maximale 100 par 100)',
                'required' => false,
                'attr' => [
                    'placeholder' => 'votre avatar',
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '300k',
                        'mimeTypes' => [
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'votre image doit ??tre au format .png',
                    ])
                ],
            ])
            
        ;
    }



    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
