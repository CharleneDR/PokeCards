<?php

namespace App\Controller;

use App\Entity\Card;
use App\Entity\Search;
use App\Form\SearchType;
use App\Service\CardService;
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
    public function index(Request $request, SearchRepository $searchRepository, CardRepository $cardRepository, CardService $cardService): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        $cards = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $name = $search->getName();
            $types = $search->getType();
            $rarities = $search->getRarity();
            $series = $search->getSeries();

            // NOT WORKING, ALWAYS USE API
            $searchExist = $searchRepository->findOneBy(['name' => $name, 'type' => $types, 'rarity' => $rarities, 'series' => $series]);
            if ($searchExist == false) {
                $apiCards = $cardService->urlMaker($search, $name, $types, $rarities, $series);
                $cards = $cardService->cardSaver($apiCards, $search);
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
