<?php

namespace App\DataFixtures;

use App\Entity\Card;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CardFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $cards = [
            ['pop6-9', 'Pikachu', 'https://images.pokemontcg.io/pop6/9_hires.png', 'https://images.pokemontcg.io/pop6/9.png', ['Lightning'], 'Pokémon',	'POP',	9,	17,	'Uncommon',	17,	14,	'Kagemaru Himeno', 'Raichu'],
            ['pop4-13',	'Pikachu',	'https://images.pokemontcg.io/pop4/13_hires.png', 'https://images.pokemontcg.io/pop4/13.png', ['Lightning'], 'Pokémon',	'POP',	13,	17,	'Common', '17',	12,	'Kouki Saitou', 'Raichu'],
            ['dp3-3', 'Charizard',	'https://images.pokemontcg.io/dp3/3_hires.png',	'https://images.pokemontcg.io/dp3/3.png', ['Fire'],	'Pokémon',	'Diamond & Pearl',	3,	132, 'Rare Holo',	132,	32,	'Daisuke Ito', null],	
            ['dp7-103',	'Charizard', 'https://images.pokemontcg.io/dp7/103_hires.png',	'https://images.pokemontcg.io/dp7/103.png',	['Fire'],	'Pokémon',	'Diamond & Pearl',	103,	106,	'Rare Secret',	100,	130,	'Mitsuhiro Arita', null],	
            ['dpp-DP45', 'Charizard G LV.X',	'https://images.pokemontcg.io/dpp/DP45_hires.png', 'https://images.pokemontcg.io/dpp/DP45.png', ['Fire'],	'Pokémon',	'Diamond & Pearl',	'DP45',	56,	'Promo',	56,	null, 'Wataru Kawahara', null]	
        ];

        foreach($cards as $card) {
            $newCard = new Card();
            $newCard->setApiId($card[0]);
            $newCard->setName($card[1]);
            $newCard->setImageLarge($card[2]);
            $newCard->setImageSmall($card[3]);
            $newCard->setType($card[4]);
            $newCard->setSupertype($card[5]);
            $newCard->setSeries($card[6]);
            $newCard->setNumber($card[7]);
            $newCard->setTotalSet($card[8]);
            $newCard->setRarity($card[9]);
            $newCard->setPrintedTotal($card[10]);
            if ($card[11] != null) {
                $newCard->setTrendPrice($card[11]);
            }
            $newCard->setArtist($card[12]);
            if ($card[13] != null) {
                $newCard->setEvolvesTo($card[13]);
            }
            $this->addReference($card[0], $newCard);
            $manager->persist($newCard);
        }

        $manager->flush();
    }
}
