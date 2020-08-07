<?php


namespace App\Form;

use App\Entity\Trick;
use App\Entity\Category;
use App\Form\PictureType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


class TrickType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, $this->getOptions('Nom', 'Nom du trick'))
            ->add('description', TextareaType::class, $this->getOptions('Description', 'Description du trick'))
            ->add('category', EntityType::class, $this->getOptions('Catégorie','Catégorie du trick', [
                'class' => Category::class,
                'choice_label' => 'name'
            ]))
            ->add('mainPicture', PictureType::class, $this->getOptions('Image principale', 'Image principale'))
            ->add('pictures', CollectionType::class, [
                'entry_type' => PictureType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('movie', TextType::class, $this->getOptions('Vidéo', 'Nom de la vidéo'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}