<?php

namespace App\Controller;

use App\Entity\Card;
use App\Repository\CardRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api', name: 'app_api')]
class ApiController extends AbstractController
{

    #[Route('/addToCollection/{id}', name: 'app_api')]
    public function addToCollection(HttpClientInterface $client, string $id, CardRepository $cardRepository, UserRepository $userRepository): Response
    {
        $card = $cardRepository->findOneByApiId($id);

        if($this->getUser()) {
            if($card != false) {
                if ($this->getUser()->isInCollection($card) == true)
                {
                    $this->getUser()->removeCollection($card);
                }
            } else {
                $response = $client->request('GET', 'https://api.pokemontcg.io/v2/cards/' . $id);
                $apiCard = $response->toArray()['data'];

                $card = new Card();
                $card->setApiId($apiCard['id']);
                $card->setName($apiCard['name']);
                $card->setImageLarge($apiCard['images']['large']);
                $card->setImageSmall($apiCard['images']['small']);
                if(isset($apiCard['types'])) {
                    $card->setType($apiCard['types']);
                }
                $card->setSupertype($apiCard['supertype']);
                $card->setSeries($apiCard['set']['series']);
                $card->setNumber($apiCard['number']);
                $card->setTotalSet($apiCard['set']['total']);
                if(isset($apiCard['rarity'])) {
                    $card->setRarity($apiCard['rarity']);
                }
                $card->setPrintedTotal($apiCard['set']['printedTotal']);
                if(isset($apiCard['cardmarket']['prices']['trendPrice'])) {
                    $card->setTrendPrice($apiCard['cardmarket']['prices']['trendPrice']);
                }
                if(isset($apiCard['artist'])) {
                    $card->setArtist($apiCard['artist']);
                }
                if(isset($apiCard['evolvesTo'])) {
                    $card->setEvolvesTo($apiCard['evolvesTo'][0]);
                }
                $cardRepository->save($card, true);
            }
            $this->getUser()->addCollection($card);

            $userRepository->save($this->getUser(), true);

            return new JsonResponse(true);
        } else {
            return new JsonResponse(false);
        }
    }
}
