<?php

namespace App\Service;

use App\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ItemService implements ItemServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    /**
     * @var HashServiceInterface
     */
    private $hashService;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserPasswordEncoderInterface $userPasswordEncoder,
        HashServiceInterface $hashService
    ) {
        $this->userRepository = $userRepository;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->hashService = $hashService;
    }

    public function create(int $userId, string $data): void
    {
        $user = $this->userRepository->getById($userId);
        $user->addItem($data, $this->hashService);
        $this->userRepository->save($user);
    }

    public function update(int $userId, int $itemId, string $data): void
    {
        $user = $this->userRepository->getById($userId);
        $user->updateItem($itemId, $data, $this->hashService);
        $this->userRepository->save($user);
    }

    public function remove(int $userId, int $itemId): void
    {
        $user = $this->userRepository->getById($userId);
        $user->removeItem($itemId);
        $this->userRepository->save($user);
    }
} 