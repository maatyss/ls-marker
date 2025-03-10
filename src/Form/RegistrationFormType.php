<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', null, [
                'label' => 'Discord',
                'attr' =>
                    [ 'placeholder' => 'discord']
            ])
            ->add('name', null, [
                'label' => 'Nom / Pseudo',
                'attr' =>
                    [ 'placeholder' => 'Juan']
            ])
            ->add('plainPassword', RepeatedType::class , [
                'type' => PasswordType::class,
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer le mot de passe'],
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min'=> 6,
                        'minMessage'=> 'Votre mot de passe doit faire {{ limit }} caractères minimum',
                        'max'=> 4096,
                    ]),
                ]

            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped'=> false,
                'label'=> 'Accepter les conditions',
                'constraints'=> [
                    new IsTrue([
                        'message'=> 'Vous devez accepter les conditions avant de vous inscrire.'
                    ])
                ]

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
