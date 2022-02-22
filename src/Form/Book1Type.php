<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Book1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('isbn')
            ->add('description')
            ->add('cover')
            ->add('normalprice')
            ->add('reduceprice')
            ->add('startdate')
            ->add('enddate')
            ->add('link')
            ->add('publisher')
            ->add('authors')
            ->add('totalprice')
            ->add('nbcomments')
            ->add('nblikes')
            ->add('status')
            ->add('user')
            ->add('type')
            ->add('category')
            ->add('subcategories')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
