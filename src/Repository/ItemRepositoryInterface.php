<?php

namespace App\Repository;

use App\Entity\User;

interface ItemRepositoryInterface
{
    public function findAllItems(User $user): array;
}