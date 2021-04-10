<?php

namespace App\Entity;

use App\Service\HashServiceInterface;
use DateTimeInterface;
use DateTimeImmutable;

class Item
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @var string
     */
    private $data;

    /**
     * @var DateTimeInterface
     */
    private $createdAt;

    /**
     * @var DateTimeInterface
     */
    private $updatedAt;

    /**
     * @var User
     */
    private $user;

    private function __construct() {}

    public static function createFromData(User $user, string $data, HashServiceInterface $hashService): self
    {
        $item = new Item();
        $item->user = $user;
        $item->changeData($data, $hashService);
        $item->createdAt = new DateTimeImmutable('now');
        $item->updatedAt = new DateTimeImmutable('now');
        return $item;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function data(): string
    {
        return $this->data;
    }

    public function user(): User
    {
        return $this->user;
    }

    public function changeData(string $data, HashServiceInterface $hashService): void
    {
        $this->data = $hashService->encode($data);
        $this->updatedAt = new DateTimeImmutable('now');
    }

    public function createdAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }
}
