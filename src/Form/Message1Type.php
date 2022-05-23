<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\User;
use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class Message1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('subject')
            ->add('book', EntityType::class, [
                'class' => Book::class,
                'label' => 'Livre (optionnel)',
                'choice_label' => 'title',
                'required' => true,
                'attr' => [
                    'class' => 'select2'
                ]
            ])
            ->add('firstMessage')
            // ->add('createdAt')
            ->add('status', CheckboxType::class, [
                'label' => "En ligne",
                'required'   => false,
                'label_attr' => [
                'class' => 'checkbox-switch',
                ],
            ])
            ->add('username', EntityType::class, [
                'class' => User::class,
                'label' => "Nom de l'utilisateur",
                'choice_label' => 'username',
                'required' => true,
                'attr' => [
                    'class' => 'select2'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
