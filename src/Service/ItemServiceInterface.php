<?php

namespace App\Service;

interface ItemServiceInterface
{
    public function create(int $userId, string $data): void;
    public function update(int $userId, int $itemId, string $data): void;
    public function remove(int $userId, int $itemId): void;
}