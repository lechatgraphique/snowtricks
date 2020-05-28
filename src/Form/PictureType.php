<?php

namespace App\Form;

use App\Entity\Picture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PictureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $widgetAttr = 'w-full appearance-none bg-gray-200 border border-grey-lighter text-grey-darker py-3 px-4 rounded focus:outline-none focus:bg-white';
        $labelAttr = 'block mb-2 uppercase tracking-wide text-grey-darker text-xs font-bold';

        $builder
            ->add('file', FileType::class, [
                'label' => 'Image :',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Picture::class,
        ]);
    }
}