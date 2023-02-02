<?php

namespace App\DataFixtures;

use App\Entity\Search;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class SearchFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $newSearch = new Search();
        $newSearch->setName('charizard');
        $newSearch->setType(" ");
        $newSearch->setRarity(" ");
        $newSearch->setSeries('dp');
        $newSearch->addCard($this->getReference('dp7-103'));
        $newSearch->addCard($this->getReference('dpp-DP45'));
        $newSearch->addCard($this->getReference('dp3-3'));
        $manager->persist($newSearch);

        $manager->flush();
    }
}
