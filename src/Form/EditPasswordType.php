<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $widgetAttr = 'w-full appearance-none bg-white border border-grey-lighter text-grey-darker py-3 px-4 rounded ';
        $labelAttr = 'block mb-2 uppercase tracking-wide text-grey-darker text-xs font-bold';

        $builder
            ->add('password',PasswordType::class, [
                'label'             => 'Mot de passe',
                'label_attr'        => [
                    'class'         => $labelAttr
                ],
                'attr'              => [
                    'placeholder'   => 'Mot de passe',
                    'class'         => $widgetAttr
                ]
            ])
            ->add('confirmPassword',PasswordType::class, [
                'label' => 'Confirmez le Mot de passe',
                'label_attr'        => [
                    'class'         => $labelAttr
                ],
                'attr'              => [
                    'placeholder'   => 'Confirmez le Mot de passe',
                    'class'         => $widgetAttr
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
