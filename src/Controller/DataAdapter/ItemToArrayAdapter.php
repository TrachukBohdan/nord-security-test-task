<?php

namespace App\Controller\DataAdapter;

use App\Entity\Item;

class ItemToArrayAdapter
{
    /**
     * @param Item[] $items
     * @return array
     */
    public function transformItems(array $items): array
    {
        $allItems = [];

        foreach ($items as $item) {
            $oneItem['id'] = $item->id();
            $oneItem['data'] = $item->data();
            $oneItem['created_at'] = $item->createdAt();
            $oneItem['updated_at'] = $item->updatedAt();
            $allItems[] = $oneItem;
        }

        return $allItems;
    }
}