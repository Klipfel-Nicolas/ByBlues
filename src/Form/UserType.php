<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class)
            ->add('roles', ChoiceType::class, [
                    'choices'  =>
                    [
                            'Admin'       => 'ROLE_ADMIN',
                            'Utilisateur' => 'ROLE_USER'
                        ],
                    'multiple' => true,
                    'expanded' => true
                    ])
            ->add('adress1', TextType::class)
            ->add('adress2', TextType::class)
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
