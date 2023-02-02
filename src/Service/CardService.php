<?php

namespace App\Service;

use App\Entity\Card;
use App\Entity\Search;
use App\Repository\CardRepository;
use App\Repository\SearchRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CardService {

    private CardRepository $cardRepository;
    private SearchRepository $searchRepository;
    private HttpClientInterface $client;

    public function __construct (CardRepository $cardRepository, SearchRepository $searchRepository, HttpClientInterface $client)
    {
        $this->cardRepository = $cardRepository;
        $this->searchRepository = $searchRepository;
        $this->client = $client;
    }

    public function urlMaker(string $name = null, array $types, array $rarities, array $series): array|false
    {
        $url = 'https://api.pokemontcg.io/v2/cards/';
    
        if ($name != null || !empty($types || $rarities || $series)) {
            $url .= '?q=';

            if ($name != null) {
                $url .= 'name:' . $name . '* ';
            }

            if (!empty($types)) {
                $url .= ' (';
                foreach($types as $type) {
                    $url .= 'types:' . $type . ' or ';
                }
                $url = substr($url, 0, -4);
                $url .= ') ';
            }

            if (!empty($rarities)) {
                $url .= ' (';
                foreach($rarities as $rarity) {
                    $url .= 'rarity:*' . $rarity . '* or ';
                }
                $url = substr($url, 0, -4);
                $url .= ') ';
            }

            if (!empty($series)) {
                $url .= '(';
                foreach($series as $serie) {
                    $url .= 'set.id:' . $serie . '* or ';
                }
                $url = substr($url, 0, -4);
                $url .= ')';
            }
            
            $url .= '&orderBy=set.series';
        }
        $response = $this->client->request('GET', $url);
        $cards = $response->toArray()['data'];
        
        return $cards;
    }

    public function cardAndSearchSaver(array $apiCards, Search $search): array
    {
        $cards = [];
        foreach ($apiCards as $card) {
            $cardExist = $this->cardRepository->findOneBy(['apiId' => $card['id']]);
            $cards[] = $cardExist;

            if ($cardExist == false) {
                $newCard = new Card();
                $newCard->setApiId($card['id']);
                $newCard->setName($card['name']);
                $newCard->setImageLarge($card['images']['large']);
                $newCard->setImageSmall($card['images']['small']);
                if(isset($card['types'])) {
                    $newCard->setType($card['types']);
                }
                $newCard->setSupertype($card['supertype']);
                $newCard->setSeries($card['set']['series']);
                $newCard->setNumber($card['number']);
                $newCard->setTotalSet($card['set']['total']);
                if(isset($card['rarity'])) {
                    $newCard->setRarity($card['rarity']);
                }
                $newCard->setPrintedTotal($card['set']['printedTotal']);
                if(isset($card['cardmarket']['prices']['trendPrice'])) {
                    $newCard->setTrendPrice($card['cardmarket']['prices']['trendPrice']);
                }
                if(isset($card['artist'])) {
                    $newCard->setArtist($card['artist']);
                }
                if(isset($card['evolvesTo'])) {
                    $newCard->setEvolvesTo($card['evolvesTo'][0]);
                }

                $cards[] = $newCard;
                $this->cardRepository->save($newCard, true);
                $search->addCard($newCard);
            } else {
                $search->addCard($cardExist);
            }
        }

        $this->searchRepository->save($search, true);
        return $cards;
    }
}
