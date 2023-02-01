<?php

namespace App\Controller;

use App\Entity\Card;
use App\Entity\Search;
use App\Form\SearchType;
use App\Repository\CardRepository;
use App\Repository\SearchRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CardController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(HttpClientInterface $client, Request $request, SearchRepository $searchRepository, CardRepository $cardRepository): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        $cards = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $name = $search->getName();
            $types = [];
            foreach($search->getType() as $type) {
                $types[] = $type;
            }
            $rarities = [];
            foreach($search->getRarity() as $rarity) {
                $rarities[] = $rarity;
            }
            $series = [];
            foreach($search->getSeries() as $serie) {
                $series[] = $serie;
            }

            // NOT WORKING
            $searchExist = $searchRepository->findOneBy(['name' => $name, 'type' => $types, 'rarity' => $rarities, 'series' => $series]);
            if ($searchExist == false) {
                $url = 'https://api.pokemontcg.io/v2/cards/';
    
                if ($name != null || !empty($types || $rarities || $series)) {
                    $url .= '?q=';
    
                    if ($name != null) {
                        $url .= 'name:' . $search->getName() . '* ';
                    }
        
                    if (!empty($types)) {
                        $url .= '(';
                        foreach($types as $type) {
                            $url .= 'types:' . $type . ' or ';
                        }
                        $url = substr($url, 0, -4);
                        $url .= ') ';
                    }
        
                    if (!empty($rarities)) {
                        $url .= '(';
                        foreach($rarities as $rarity) {
                            $url .= 'rarity:' . $rarity . ' or ';
                        }
                        $url = substr($url, 0, -4);
                        $url .= ') ';
                    }
        
                    if (!empty($series)) {
                        $url .= '(';
                        foreach($series as $serie) {
                            $url .= 'set.series:' . $serie . ' or ';
                        }
                        $url = substr($url, 0, -4);
                        $url .= ') ';
                    }
                }
                $response = $client->request('GET', $url);
                $cards = $response->toArray()['data'];
    
                foreach ($cards as $card) {
                    $cardExist = $cardRepository->findOneBy(['apiId' => $card['id']]);
                    if ($cardExist == false) {
                        $newCard = new Card();
                        $newCard->setApiId($card['id']);
                        $newCard->setName($card['name']);
                        $newCard->setImageLarge($card['images']['large']);
                        $newCard->setImageSmall($card['images']['small']);
                        $newCard->setType($card['types']);
                        $newCard->setSupertype($card['supertype']);
                        $newCard->setSeries($card['set']['series']);
                        $newCard->setNumber($card['number']);
                        $newCard->setTotalSet($card['set']['total']);
                        if(isset($card['rarity'])) {
                            $newCard->setRarity($card['rarity']);
                        }
                        $newCard->setPrintedTotal($card['set']['printedTotal']);
                        $newCard->setTrendPrice($card['cardmarket']['prices']['trendPrice']);
                        if(isset($card['artist'])) {
                            $newCard->setArtist($card['artist']);
                        }
                        if(isset($card['evolvesTo'])) {
                            $newCard->setEvolvesTo($card['evolvesTo'][0]);
                        }
        
                        $cardRepository->save($newCard, true);
                        $search->addCard($newCard);
                        $searchRepository->save($search, true);
                    }
                }
            } else {
                $cards = $searchExist->getCards();
            }            
        }

        return $this->render('card/index.html.twig', [
            'form' => $form,
            'cards' => $cards
        ]);
    }

    #[Route('/card/{id}', name: 'app_show')]
    public function show(HttpClientInterface $client, string $id, CardRepository $cardRepository): Response
    {

        $cardExist = $cardRepository->findOneBy(['apiId' => $id]);
        if ($cardExist != false) {
            $card = $cardExist;
            return $this->render('card/show.html.twig', [
                'card' => $card
            ]);
   
        } else {
            $response = $client->request('GET', 'https://api.pokemontcg.io/v2/cards/' . $id);
            $card = $response->toArray()['data'];
            return $this->render('card/showApi.html.twig', [
                'card' => $card
            ]);
        }

    }
}
