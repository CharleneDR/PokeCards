<?php

namespace App\Controller;

use App\Form\SearchCardType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CardController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(HttpClientInterface $client): Response
    {
        $form = $this->createForm(SearchCardType::class);

        //$cards = $response->toArray()['data'];

        return $this->render('card/index.html.twig', [
            'form' => $form,
            //'cards' => $cards
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
