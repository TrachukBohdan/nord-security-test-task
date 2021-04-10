<?php

namespace App\Tests\Unit;

use App\Entity\User;
use App\Repository\UserRepositoryInterface;
use App\Service\ItemService;
use App\Service\ItemServiceInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ItemServiceTest extends TestCase
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var ItemServiceInterface
     */
    private $itemService;

    /**
     * @var User
     */
    private $user;

    public function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $this->user = $this->createMock(User::class);
        $this->itemService = new ItemService($this->userRepository, $this->passwordEncoder);
    }

    public function testCreate(): void
    {
        $userId = 1;
        $itemData = 'securet data';

        $this->user
            ->expects($this->once())
            ->method('addItem')
            ->with($itemData);

        $this->userRepository
            ->expects($this->once())
            ->method('getById')
            ->with($userId)
            ->willReturn($this->user);

        $this->userRepository
            ->expects($this->once())
            ->method('save')
            ->with($this->user);

        $this->itemService->create(1, $itemData);
    }
    public function testUpdate(): void
    {
        $userId = 1;
        $itemId = 2;
        $itemData = 'securet data';

        $this->user
            ->expects($this->once())
            ->method('updateItem')
            ->with($itemId, $itemData);

        $this->userRepository
            ->expects($this->once())
            ->method('getById')
            ->with($userId)
            ->willReturn($this->user);

        $this->userRepository
            ->expects($this->once())
            ->method('save')
            ->with($this->user);

        $this->itemService->update($userId, $itemId, $itemData);
    }

    public function testRemove(): void
    {
        $userId = 1;
        $itemId = 2;
        $this->user
            ->expects($this->once())
            ->method('removeItem')
            ->with($itemId);

        $this->userRepository
            ->expects($this->once())
            ->method('getById')
            ->with($userId)
            ->willReturn($this->user);

        $this->userRepository
            ->expects($this->once())
            ->method('save')
            ->with($this->user);

        $this->itemService->remove($userId, $itemId);
    }
}
