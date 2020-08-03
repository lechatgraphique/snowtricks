<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, $this->getOptions("", "Votre nom d'utilisateur", ['label'=> false]))
            ->add('email', EmailType::class, $this->getOptions("Emil", "Votre adresse email", ['label'=> false]))
            ->add('file', FileType::class, $this->getOptions("", "Photo de profil", ['label'=> false]))
            ->add('password', PasswordType::class, $this->getOptions("", "Votre mot de passe", ['label'=> false]))
            ->add('passwordConfirm', PasswordType::class, $this->getOptions("", "Retaper votre mot de passe", ['label'=> false]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

