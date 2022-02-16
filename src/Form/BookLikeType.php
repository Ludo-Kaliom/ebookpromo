<?php

namespace App\Form;

use App\Entity\BookLike;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class BookLikeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('like', CheckboxType::class, [
                'label' => "J'aime",
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => "Pour vous inscrire, vous devez approuver nos conditions d'utilisation",
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BookLike::class,
        ]);
    }
}
