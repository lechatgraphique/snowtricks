<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $widgetAttr = 'w-full appearance-none bg-gray-200 border border-grey-lighter text-grey-darker py-3 px-4 rounded focus:outline-none focus:bg-white';
        $labelAttr = 'block mb-2 uppercase tracking-wide text-grey-darker text-xs font-bold';

        $builder
            ->add('name',TextType::class, [
                'label'             => 'Catégorie',
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
            'data_class' => Category::class,
        ]);
    }
}
