<?php

namespace App\Form;

use App\Entity\Search;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name of the card',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false,
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    "Grass" => "Grass",
                    "Water" => "Water",
                    "Fire" => "Fire",
                    "Lightning" => "Lightning",
                    "Fighting" => "Fighting",
                    "Psychic" => "Psychic",
                    "Metal" => "Metal",
                    "Dragon" => "Dragon",
                    "Darkness" => "Darkness",
                    "Fairy" => "Fairy",
                    "Colorless" => "Colorless"
                ],
                'multiple' => true,
                'expanded' => true,
                'label' => 'Type',
                'attr' => [
                    'class' => 'form-control collapse',
                ],
                'row_attr' => [
                    'class' => 'mx-3',
                ],
                'required' => false,
            ])

            ->add('rarity', ChoiceType::class, [
                'choices' => [
                    "Amazing Rare" => "Amazing Rare",
                    "Common" => "Common",
                    "Legend" => "Legend",
                    "Promo" => "Promo",
                    "Rare" => "Rare",
                    "Rare ACE" => "Rare ACE",
                    "Rare BREAK" => "Rare BREAK",
                    "Rare Holo" => "Rare Holo",
                    "Rare Prime" => "Rare Prime",
                    "Rare Prism Star" => "Rare Prism Star",
                    "Rare Rainbow" => "Rare Rainbow",
                    "Rare Secret" => "Rare Secret",
                    "Rare Shining" => "Rare Shining",
                    "Rare Shiny" => "Rare Shiny",
                    "Rare Ultra" => "Rare Ultra",
                    "Uncommon" => "Uncommon"
                ],
                'multiple' => true,
                'expanded' => true,
                'label' => "Rarity",
                'attr' => [
                    'class' => 'form-control collapse',
                ],
                'row_attr' => [
                    'class' => 'mx-3',
                ],
                'required' => false,
            ])

            ->add('series', ChoiceType::class, [
                'choices' => [
                    "Base" => "Base",
                    "Black & White" => "Black & White",
                    "Diamond & Pearl" => "Diamond & Pearl",
                    "E-Card" => "E-Card",
                    "EX" => "EX",
                    "Gym" => "Gym",
                    "HeartGold & SoulSilver" => "HeartGold & SoulSilver",
                    "NP" => "NP",
                    "Neo" => "Neo",
                    "Other" => "Other",
                    "POP" => "POP",
                    "Platinum" => "Platinum",
                    "Sun & Moon" => "Sun & Moon",
                    "Sword & Shield" => "Sword & Shield",
                    "XY" => "XY"
                ],
                'multiple' => true,
                'expanded' => true,
                'label' => "Series",
                'attr' => [
                    'class' => 'form-control collapse',
                ],
                'row_attr' => [
                    'class' => 'mx-3',
                ],
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
        ]);
    }
}
