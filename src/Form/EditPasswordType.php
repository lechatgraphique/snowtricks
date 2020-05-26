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
            ->add('oldPassword',PasswordType::class, [
                'label'             => 'Ancien mot de passe',
                'required'          =>  false,
                'label_attr'        => [
                    'class'         => $labelAttr
                ],
                'attr'              => [
                    'placeholder'   => 'Ancien mot de passe',
                    'class'         => $widgetAttr
                ]
            ])
            ->add('newPassword',PasswordType::class, [
                'label'             => 'Nouveau mot de passe',
                'required'          =>  false,
                'label_attr'        => [
                    'class'         => $labelAttr
                ],
                'attr'              => [
                    'class'         => $widgetAttr
                ]
            ])
            ->add('confirmPassword',PasswordType::class, [
                'label' => 'Confirmer le nouveau mot de passe',
                'required'          =>  false,
                'label_attr'        => [
                    'class'         => $labelAttr
                ],
                'attr'              => [
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
