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
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CardController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(Request $request, SearchRepository $searchRepository, CardRepository $cardRepository, CardService $cardService): Response
    {
        $form = $this->createForm(SearchType::class);

        $session = $request->getSession();
        $form->get('name')->setData($session->get('searchName'));
        $session->remove('name');

        $form->handleRequest($request);
        $cards = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $name = $form->getData()['name'];
            $types = $form->getData()['type'];
            $rarities = $form->getData()['rarity'];
            $series = $form->getData()['series'];

            $searchExist = $searchRepository->findOneBy(['name' => $name, 'type' => implode(', ', $types), 'rarity' => implode(', ', $rarities), 'series' => implode(', ' ,$series)]);
            if ($searchExist == false) {
                $apiCards = $cardService->urlMaker($name, $types, $rarities, $series);

                $search = new Search();
                $search->setName($name);
                $search->setType(implode( ', ', $types));
                $search->setRarity(implode(', ', $rarities));
                $search->setSeries(implode(', ', $series));

                $cards = $cardService->cardAndSearchSaver($apiCards, $search);
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

    #[Route('/redirectToSearch/{name}', name: 'app_redirectToSearch')]
    public function redirectToSearch(string $name, Request $request): Response
    {
        $session = $request->getSession();
        $session->set('searchName', $name);
        return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
    }
}
