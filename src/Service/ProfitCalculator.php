<?php

namespace App\Service;

use App\Entity\Inventory;
use App\Entity\Sell;
use App\Repository\InventoryRepository;
use App\Repository\SellRepository;
use Doctrine\Persistence\ObjectManager;

class ProfitCalculator
{
    private $inventoryRepository;

    public function __construct(
        InventoryRepository $inventoryRepository)
    {
        $this->inventoryRepository = $inventoryRepository;
    }

    public function calculate(Sell $sell,ObjectManager $entityManager)
    {

        // get the total number of requested items
        $itemCount = $sell->getQuantity();
        $totalItems = $this->inventoryRepository->getTotalInventoryItems();
        if($totalItems['quantity'] <$itemCount) {
            return false;
        }
        // get each inventory item
        $inventories = $this->inventoryRepository->findAll();
        $inventoryPrice = 0;
        foreach($inventories as $inventory) {
            if($itemCount <=0) break;
            if($inventory->getQuantity() <= $itemCount) {
                // all items of inventory is required to fullfill.
                $itemCount = $itemCount - $inventory->getQuantity();
                $inventoryPrice = $inventoryPrice + ($inventory->getQuantity() * $inventory->getPrice());
                // remove it from inventory
                $entityManager->remove($inventory);
                $entityManager->flush();
            } else {
                // not all item required
                $inventoryNewCount = $inventory->getQuantity() - $itemCount;

                $inventoryPrice = $inventoryPrice + ($itemCount * $inventory->getPrice());
                $inventory->setQuantity($inventoryNewCount);
                $entityManager->persist($inventory);
                $entityManager->flush();
                break;
            }
        }
        return ($sell->getPrice()*$sell->getQuantity()) - $inventoryPrice;

    }

}
