<?php

namespace App\Service;

use App\Entity\Card;
use App\Entity\Search;
use App\Repository\CardRepository;
use App\Repository\SearchRepository;
use Doctrine\ORM\PersistentCollection;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CardService
{
    private CardRepository $cardRepository;
    private SearchRepository $searchRepository;
    private HttpClientInterface $client;

    public function __construct(
        CardRepository $cardRepository,
        SearchRepository $searchRepository,
    ) {
        $this->cardRepository = $cardRepository;
        $this->searchRepository = $searchRepository;
    }

    public function urlMaker(string $name = null, array $types, array $rarities, array $series): string
    {
        $url = 'https://api.pokemontcg.io/v2/cards/';
    
        if ($name != null || !empty($types || $rarities || $series)) {
            $url .= '?q=';

            if ($name != null) {
                $url .= 'name:' . $name . '* ';
            }

            if (!empty($types)) {
                $url .= ' (';
                foreach ($types as $type) {
                    $url .= 'types:' . $type . ' or ';
                }
                $url = substr($url, 0, -4);
                $url .= ') ';
            }

            if (!empty($rarities)) {
                $url .= ' (';
                foreach ($rarities as $rarity) {
                    $url .= 'rarity:*' . $rarity . '* or ';
                }
                $url = substr($url, 0, -4);
                $url .= ') ';
            }

            if (!empty($series)) {
                $url .= '(';
                foreach ($series as $serie) {
                    $url .= 'set.id:' . $serie . '* or ';
                }
                $url = substr($url, 0, -4);
                $url .= ')';
            }
            
            $url .= '&orderBy=set.series';
        }
        
        return $url;
    }

    public function cardSaver(array $apiCards): array
    {
        $cards = [];
        foreach ($apiCards as $card) {
            $cardExist = $this->cardRepository->findOneBy(['apiId' => $card['id']]);

            if ($cardExist == false) {
                $newCard = new Card();
                $newCard->setApiId($card['id']);
                $newCard->setName($card['name']);
                $newCard->setImageLarge($card['images']['large']);
                $newCard->setImageSmall($card['images']['small']);
                if (isset($card['types'])) {
                    $newCard->setType($card['types']);
                }
                $newCard->setSupertype($card['supertype']);
                $newCard->setSeries($card['set']['series']);
                $newCard->setNumber($card['number']);
                $newCard->setTotalSet($card['set']['total']);
                if (isset($card['rarity'])) {
                    $newCard->setRarity($card['rarity']);
                }
                $newCard->setPrintedTotal($card['set']['printedTotal']);
                if (isset($card['cardmarket']['prices']['trendPrice'])) {
                    $newCard->setTrendPrice($card['cardmarket']['prices']['trendPrice']);
                }
                if (isset($card['artist'])) {
                    $newCard->setArtist($card['artist']);
                }
                if (isset($card['evolvesTo'])) {
                    $newCard->setEvolvesTo($card['evolvesTo'][0]);
                }

                $cards[] = $newCard;
                $this->cardRepository->save($newCard, true);
            } else {
                $cards[] = $cardExist;
            }
        }

        return $cards;
    }

    public function getTotalPrice(PersistentCollection $cards): int
    {
        $totalPrice = 0;
        foreach ($cards as $card) {
            $totalPrice += $card->getTrendPrice();
        }

        return $totalPrice;
    }
}
