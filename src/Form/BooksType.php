<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Author;
use App\Entity\Publisher;
use App\Repository\PublisherRepository;
use Doctrine\ORM\Mapping\OrderBy;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BooksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => "Titre",
                'attr' => [
                    'placeholder' => "Titre du livre"
                ]
            ])
            ->add('authors')
            // ->add('publishers')
            ->add('publishers', EntityType::class, [
                'class' => Publisher::class,
                'choice_label' => 'name',
                'mapped' => false
            ])
            ->add('isbn', TextType::class,  [
                'label' => "ISBN",
                'attr' => [
                'placeholder' => "ISBN du livre"
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => "Résumé",
                'attr' => [
                'placeholder' => "Quatrième de couverture du livre"
                ]
            ])
            ->add('cover', FileType::class, [
                'label' => 'Image de couverture'
            ])
            ->add('normalPrice', MoneyType::class, [
                'label' => "Prix normal du livre",
                'attr' => [
                'placeholder' => "Prix du livre avant réduction"
                ]
            ])
            ->add('reducePrice', MoneyType::class, [
                'label' => "Prix du livre après promotion",
                'attr' => [
                'placeholder' => "Prix du livre pendant la promotion"
                ]
            ])
            ->add('startDate', DateType::class, [
                'label' => "Date de début de la promotion"
            ])
            ->add('endDate', DateType::class, [
                'label' => "Date de fin de la promotion"
            ])
            ->add('link', UrlType::class, [
                'label' => "Où trouver la promotion",
                'attr' => [
                'placeholder' => "Lien vers un site de vente"
                ]
            ])
            ->add('categories')

            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
