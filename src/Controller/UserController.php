<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\CardService;
use App\Repository\CardRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(UserRepository $userRepository, CardRepository $cardRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
            'cards' => $cardRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user, CardService $cardService): Response
    {
        $cards = $user->getCollection();
        $priceCollection = $cardService->getTotalPrice($cards);

        return $this->render('user/show.html.twig', [
            'user' => $user,
            'priceCollection' => $priceCollection
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $userConnected = $this->getUser();
        if ($userConnected && (in_array('ROLE_ADMIN', $userConnected->getRoles()) || $userConnected == $user)) {
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $userRepository->save($user, true);
                return $this->redirectToRoute('app_user_show', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('user/edit.html.twig', [
                'user' => $user,
                'form' => $form,
            ]);
        } else {
            return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            if ($this->getUser() != $user) {
                $userRepository->remove($user, true);
            } else {
                $this->addFlash('red', "You can't delete your own account");
                return $this->redirectToRoute('app_user_show', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
