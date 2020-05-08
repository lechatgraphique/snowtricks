<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $widgetAttr = 'w-full appearance-none bg-white border border-grey-lighter text-grey-darker py-3 px-4 rounded ';
        $labelAttr = 'block mb-2 uppercase tracking-wide text-grey-darker text-xs font-bold';

        $builder
            ->add('username',EmailType::class, [
                'label'             => 'Email',
                'label_attr'        => [
                    'class'         => $labelAttr
                ],
                'attr'              => [
                    'placeholder'   => 'Email',
                    'class'         => $widgetAttr
                ]
            ])
            ->add('avatar',FileType::class, [
                'label'             => 'Photo de profil',
                'mapped'            => false,
                'required'          =>  false,
                'constraints' => [
                    new File([
                        'maxSize'   => '1024k',
                        'mimeTypes' => [
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger votre image de profil forme de fichier Jpg.',
                    ])
                ],
                'label_attr'        => [
                    'class'         => $labelAttr
                ],
                'attr'              => [
                    'placeholder'   => 'Photo de profil',
                    'class'         => $widgetAttr
                ]
            ])
            ->add('country', IntegerType::class, [
                'label'             => 'Département',
                'required'          =>  false,
                'label_attr'        => [
                    'class'         => $labelAttr
                ],
                'attr'              => [
                    'placeholder'   => '75',
                    'class'         => $widgetAttr
                ]
            ])
            ->add('firstName',TextType::class, [
                'label'             => 'Prénom',
                'label_attr'        => [
                    'class'         => $labelAttr
                ],
                'attr'              => [
                    'placeholder'   => 'Prénom',
                    'class'         => $widgetAttr
                ]
            ])
            ->add('lastName',TextType::class, [
                'label'             => 'Nom',
                'label_attr'        => [
                    'class'         => $labelAttr
                ],
                'attr'              => [
                    'placeholder'   => 'Nom',
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
