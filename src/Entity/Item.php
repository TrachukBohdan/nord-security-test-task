<?php

namespace App\Entity;

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

    public static function createFromData(User $user, string $data): self
    {
        $item = new Item();
        $item->user = $user;
        $item->data = $data;
        $item->createdAt = new DateTimeImmutable('now');
        $item->updatedAt = new DateTimeImmutable('now');
        return $item;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function data(): ?string
    {
        return $this->data;
    }

    public function user(): User
    {
        return $this->user;
    }

    public function changeData(string $data): void
    {
        $this->data = $data;
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
