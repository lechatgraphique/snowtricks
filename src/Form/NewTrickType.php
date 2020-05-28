<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Picture;
use App\Entity\Trick;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class NewTrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $widgetAttr = 'w-full appearance-none bg-gray-200 border border-grey-lighter text-grey-darker py-3 px-4 rounded focus:outline-none focus:bg-white';
        $labelAttr = 'block mb-2 uppercase tracking-wide text-grey-darker text-xs font-bold';

        $builder
            ->add('title',TextType::class, [
                'label' => 'Titre',

            ])
            ->add('isValid',ChoiceType::class, [
                'choices'  => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'label' => 'Visible ?',

            ])
            ->add('pictures', CollectionType::class, [
                'entry_type' => PictureType::class,
                'allow_add' => true,
                'allow_delete' => true,
                "by_reference" => false,
            ])
            ->add('description',TextareaType::class, [
                'label' => 'Description',
                'attr' => ['rows' => 14],

            ])
            ->add('mainPicture',FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'required' =>  false,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                        'image/png',
                        'image/jpg',
                        'image/jpeg'
                    ],
                    'mimeTypesMessage' => 'Le fichier doit être de type jpeg ou png.'
                ]),
                ],

            ])
            ->add('youtubeMovie',TextType::class, [
                'label' => 'Vidéo',

            ])
            ->add('categories', EntityType::class, [
                'label' => 'Catégorie',

                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
