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

        $builder
            ->add('title',TextType::class, [
                'label' => 'Titre',

            ])
            ->add('isValid',ChoiceType::class, [
                'choices'  => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'label' => 'Statut',

            ])
            ->add('pictures', CollectionType::class, [
                'label' => 'Collection d\'images',
                'entry_type' => PictureType::class,
                'allow_add' => true,
                'allow_delete' => true,
                "by_reference" => false,
            ])
            ->add('description',TextareaType::class, [
                'label' => 'Description',
                'attr' => ['rows' => 8],

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
                'label' => 'Vidéo YouTube',

            ])
            ->add('categories', EntityType::class, [
                'label' => 'Catégorie(s)',

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
