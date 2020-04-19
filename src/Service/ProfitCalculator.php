<?php
/**
 * ProfitCalculator.php
 *
 * PHP version 7
 *
 * @category Service
 *
 * @package App\Service
 *
 * @author Faysal Ahmed <faysal.ahmed833@gmail.com>
 *
 * @license custom license http://www.eskimi.com/
 *
 * @link http://www.eskimi.com/
 */

namespace App\Service;

use App\Entity\Sell;
use App\Repository\InventoryRepository;
use Doctrine\Persistence\ObjectManager;

/**
 * ProfitCalculator class
 *
 * PHP version 7
 *
 * @category Service
 *
 * @package App\Service
 *
 * @author Faysal Ahmed <faysal.ahmed833@gmail.com>
 *
 * @license custom license http://www.eskimi.com/
 *
 * @link http://www.eskimi.com/
 */
class ProfitCalculator
{
    /**
     * Variable for inventory repository
     *
     * @var InventoryRepository
     */
    private $_inventoryRepository;

    /**
     * ProfitCalculator constructor.
     *
     * @param InventoryRepository $inventoryRepository injector
     */
    public function __construct(
        InventoryRepository $inventoryRepository
    ) {
        $this->_inventoryRepository = $inventoryRepository;
    }

    /**
     * Calculate profit for a sell
     *
     * @param Sell          $sell          sell object
     * @param ObjectManager $entityManager entity manager to manipulate database
     *
     * @return float|int
     */
    public function calculate(Sell $sell, ObjectManager $entityManager)
    {
        $itemCount = $sell->getQuantity();

        $totalItems = $this->_inventoryRepository->getTotalRemainingItems();
        if ($totalItems < $itemCount) {
            return -1;
        }

        $inventoryPrice = 0;

        $inventories = $this->_inventoryRepository->findAllByRemainingItems();
        foreach ($inventories as $inventory) {
            if ($itemCount <= 0) {
                break;
            }

            if ($inventory->getRemaining() <= $itemCount) {
                $itemCount = $itemCount - $inventory->getRemaining();

                $inventoryPrice = $inventoryPrice +
                    ($inventory->getRemaining() * $inventory->getPrice());
                $inventory->setRemaining(0);
                $entityManager->persist($inventory);
                $entityManager->flush();
            } else {
                $inventoryNewCount = $inventory->getRemaining() - $itemCount;

                $inventoryPrice = $inventoryPrice +
                    ($itemCount * $inventory->getPrice());

                $inventory->setRemaining($inventoryNewCount);
                $entityManager->persist($inventory);
                $entityManager->flush();
                break;
            }
        }
        return ($sell->getPrice() * $sell->getQuantity()) - $inventoryPrice;
    }
}
