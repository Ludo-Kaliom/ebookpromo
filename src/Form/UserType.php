<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            // ->add('roles')
            ->add('plainPassword', RepeatedType::class, [
                // 'label' => 'Changer de mot de passe',
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'placeholder' => "Votre mot de passe",
                ],
                'constraints' => [
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit faire au minimum {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'first_options'  => ['label' => 'Changer votre mot de passe'],
                'second_options' => ['label' => 'Repétez le mot de passe'],
            ])
            ->add('username')
            // ->add('avatar')
            ->add('registrationdate')
            ->add('updated')
            ->add('subscription', CheckboxType::class, [
                'label' => "Abonné aux notifications",
                'required'   => false,
                'label_attr' => [
                'class' => 'checkbox-switch',
                ],
            ])
            ->add('status', CheckboxType::class, [
                'label' => "Valider",
                'required'   => false,
                'label_attr' => [
                'class' => 'checkbox-switch',
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
