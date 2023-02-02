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
                    "Amazing Rare" => "Amazing",
                    "Common" => "Common",
                    "Legend" => "Legend",
                    "Promo" => "Promo",
                    "Rare" => "Rare",
                    "Rare ACE" => "ACE",
                    "Rare BREAK" => "BREAK",
                    "Rare Holo" => "Holo",
                    "Rare Prime" => "Prime",
                    "Rare Prism Star" => "Prism",
                    "Rare Rainbow" => "Rainbow",
                    "Rare Secret" => "Secret",
                    "Rare Shining" => "Shining",
                    "Rare Shiny" => "Shiny",
                    "Rare Ultra" => "Ultra",
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
                    "Base" => "base",
                    "Black & White" => "bw",
                    "Diamond & Pearl" => "dp",
                    "E-Card" => "ecard",
                    "EX" => "ex",
                    "Gym" => "gym",
                    "HeartGold & SoulSilver" => "hgss",
                    "NP" => "np",
                    "Neo" => "neo",
                    "POP" => "pop",
                    "Platinum" => "pl",
                    "Sun & Moon" => "sm",
                    "Sword & Shield" => "swsh",
                    "Trainer Kit" => "tk",
                    "XY" => "xy"
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
}
