<?php

namespace App\Repository;

use App\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;
    public function remove(User $user): void;
    public function getById(int $id): User;
    public function getByUsername(string $username): User;
}