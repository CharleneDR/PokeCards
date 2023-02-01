<?php

namespace App\Controller;

use App\Entity\Search;
use App\Form\SearchType;
use App\Repository\SearchRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CardController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(HttpClientInterface $client, Request $request, SearchRepository $searchRepository): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        $cards=[];

        if ($form->isSubmitted() && $form->isValid()) {
            $name = $search->getName();
            $types = $search->getType();
            $rarities = $search->getRarity();
            $series = $search->getSeries();
            $searchRepository->save($search, true);

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
        }

        return $this->render('card/index.html.twig', [
            'form' => $form,
            'cards' => $cards
        ]);
    }

    #[Route('/card/{id}', name: 'app_show')]
    public function show(HttpClientInterface $client, string $id): Response
    {
        $response = $client->request('GET', 'https://api.pokemontcg.io/v2/cards/' . $id);
        $card = $response->toArray()['data'];

        return $this->render('card/show.html.twig', [
            'card' => $card
        ]);
    }
}
