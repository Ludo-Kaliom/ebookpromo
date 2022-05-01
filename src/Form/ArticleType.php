<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('updated', DateType::class, [
                "label" => "Date"
            ])
            ->add('status', CheckboxType::class, [
                'label' => "En ligne",
                'required'   => false,
                'label_attr' => [
                'class' => 'checkbox-switch',
                ],
            ])
            ->add('content', CKEditorType::class)
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username',
                'label' => 'Pseudonyme'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
