<?php

namespace App\Controller\DataAdapter;

use App\Entity\Item;
use App\Service\HashServiceInterface;

class ItemToArrayAdapter
{
    /**
     * @param Item[] $items
     * @param HashServiceInterface $hashService
     * @return array
     */
    public function transformItems(array $items, HashServiceInterface $hashService): array
    {
        $allItems = [];

        foreach ($items as $item) {
            $oneItem['id'] = $item->id();
            $oneItem['data'] = $hashService->decode($item->data());
            $oneItem['created_at'] = $item->createdAt();
            $oneItem['updated_at'] = $item->updatedAt();
            $allItems[] = $oneItem;
        }

        return $allItems;
    }
}