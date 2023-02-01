<?php

namespace App\Controller;

use App\Repository\CardRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api', name: 'app_api')]
class ApiController extends AbstractController
{

    #[Route('/addToCollection/{id}', name: 'app_api')]
    public function addToCollection(string $id, CardRepository $cardRepository, UserRepository $userRepository): Response
    {
        $card = $cardRepository->findOneByApiId($id);
        if($this->getUser()) {
            if ($this->getUser()->isInCollection($card) == true)
            {
                $this->getUser()->removeCollection($card);
            } else {
                $this->getUser()->addCollection($card);
            }

            $userRepository->save($this->getUser(), true);

            return new JsonResponse(true);
        } else {
            return new JsonResponse(false);
        }
    }
}
