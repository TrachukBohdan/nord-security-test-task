<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\DataAdapter\ItemToArrayAdapter;
use App\Exception\ItemNotFoundException;
use App\Exception\UserNotFoundException;
use App\Repository\ItemRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Service\HashServiceInterface;
use App\Service\ItemService;
use App\Service\ItemServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ItemController extends AbstractController
{
    /**
     * @Route("/item", name="item_list", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function list(
        UserRepositoryInterface $userRepository,
        ItemRepositoryInterface $itemRepository,
        ItemToArrayAdapter $itemToArrayAdapter,
        HashServiceInterface $hashService
    ): JsonResponse
    {
       try {
            $user = $userRepository->getByUsername($this->getUser()->getUsername());
            $items = $itemRepository->findAllItems($user);
            return $this->json($itemToArrayAdapter->transformItems($items, $hashService));
       } catch (UserNotFoundException $userNotFoundException) {
           return $this->json(['error' => 'user not found'], Response::HTTP_BAD_REQUEST);
       } catch (\Throwable $exception) {
           return $this->json(['error' => 'failed'], Response::HTTP_INTERNAL_SERVER_ERROR);
       }
    }

    /**
     * @Route("/item", name="item_create", methods={"POST"})
     * @IsGranted("ROLE_USER")
     */
    public function create(
        Request $request,
        UserRepositoryInterface $userRepository,
        ItemServiceInterface $itemService
    ) {
        $data = $request->get('data');

        if (empty($data)) {
            return $this->json(['error' => 'No data parameter']);
        }

        try {
            $user = $userRepository->getByUsername($this->getUser()->getUsername());
            $itemService->create($user->id(), (string) $data);
            return $this->json([]);
        } catch (UserNotFoundException $userNotFoundException) {
            return $this->json(['error' => 'user not found'], Response::HTTP_BAD_REQUEST);
        } catch (Throwable $exception) {
            return $this->json(['error' => 'failed'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @Route("/item", name="item_update", methods={"PUT"})
     * @IsGranted("ROLE_USER")
     */
    public function update(
        Request $request,
        UserRepositoryInterface $userRepository,
        ItemService $itemService
    ) {
        if (empty($request->get('data'))) {
            return $this->json(['error' => 'No data parameter']);
        }

        if (empty($request->get('id'))) {
            return $this->json(['error' => 'No id parameter']);
        }

        try {
            $user = $userRepository->getByUsername($this->getUser()->getUsername());
            $itemService->update(
                $user->id(),
                (int) $request->get('id'),
                (string) $request->get('data')
            );
            return $this->json([]);
        } catch (UserNotFoundException $userNotFoundException) {
            return $this->json(['error' => 'user not found'], Response::HTTP_BAD_REQUEST);
        } catch (ItemNotFoundException $itemNotFoundException) {
            return $this->json(['error' => 'item not found'], Response::HTTP_BAD_REQUEST);
        } catch (Throwable $throwable) {
            return $this->json(['error' => 'failed'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * @Route("/item/{id}", name="items_delete", methods={"DELETE"})
     * @IsGranted("ROLE_USER")
     */
    public function delete(
        UserRepositoryInterface $userRepository,
        ItemServiceInterface $itemService,
        int $id
    ) {
        if (empty($id)) {
            return $this->json(['error' => 'No data parameter'], Response::HTTP_BAD_REQUEST);
        }

        try {
            $user = $userRepository->getByUsername($this->getUser()->getUsername());
            $itemService->remove($user->id(), (int) $id);
            return $this->json([]);
        } catch (UserNotFoundException $userNotFoundException) {
            return $this->json(['error' => 'user not found'], Response::HTTP_BAD_REQUEST);
        } catch (ItemNotFoundException $itemNotFoundException) {
            return $this->json(['error' => 'no item'], Response::HTTP_BAD_REQUEST);
        } catch (Throwable $throwable) {
            return $this->json(['error' => 'failed'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
