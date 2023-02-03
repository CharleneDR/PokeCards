<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('username', TextType::class, [
            'required' => true,
            'label' => 'Username',
            'attr' => [
                'class' => 'form-control m-auto',
            ]
        ])

        ->add('email', EmailType::class, [
            'required' => true,
            'label' => 'Email',
            'attr' => [
                'class' => 'form-control m-auto',
            ]
        ])

        ->add('country', CountryType::class, [
            'label' => 'Country',
            'attr' => [
                'class' => 'form-control m-auto',
            ],
            'choice_translation_domain' => 'EN',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
