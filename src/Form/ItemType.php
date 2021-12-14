<?php

namespace App\Form;

use App\Entity\Item;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('price', NumberType::class)
            /* ->add('displayPerDay', NumberType::class) */
            ->add('quantityAviable', NumberType::class)
            /* ->add('isPreOrder') */
            ->add('description', TextareaType::class)
            ->add('image1', FileType::class, [
                'mapped' => false,
                'required' => false,
            ])
            ->add('image2', FileType::class, [
                'mapped' => false,
                'required' => false,
            ])
            ->add('image3', FileType::class, [
                'mapped' => false,
                'required' => false,
            ])
            ->add('image4', FileType::class, [
                'mapped' => false,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
        ]);
    }
}
