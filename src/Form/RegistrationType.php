<?php

namespace App\Form;

use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $inputStyle = 'py-4 appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white';

        $builder
            ->add('username',TextType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Email',
                    'class' => $inputStyle
                ]
            ])
            ->add('password',PasswordType::class, [
                'label' => 'Mot de passe',
                'attr' => [
                    'placeholder' => 'Mot de passe',
                    'class' => $inputStyle
                ]
            ])
            ->add('confirmPassword',PasswordType::class, [
                'label' => 'Confirmez le Mot de passe',
                'attr' => [
                    'placeholder' => 'Confirmez votre mot de passe',
                    'class' => $inputStyle
                ]
            ])
            ->add('firstName',TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Prénom',
                    'class' => $inputStyle
                ]
            ])
            ->add('lastName',TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Nom',
                    'class' => $inputStyle
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

