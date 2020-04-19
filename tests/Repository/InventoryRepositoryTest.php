<?php
/**
 * Test file for  Inventory Repository
 *
 * PHP version 7
 *
 * @category Tests
 *
 * @package App\Tests\Repository
 *
 * @author Faysal Ahmed <faysal.ahmed833@gmail.com>
 *
 * @license custom license http://www.eskimi.com/
 *
 * @link http://www.eskimi.com/
 */

namespace App\Tests\Repository;

use App\Entity\Inventory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use \Doctrine\Persistence\ObjectManager;

/**
 * Test Class for  Inventory Repository
 *
 * PHP version 7
 *
 * @category Tests
 *
 * @package App\Tests\Repository
 *
 * @author Faysal Ahmed <faysal.ahmed833@gmail.com>
 *
 * @license custom license http://www.eskimi.com/
 *
 * @link http://www.eskimi.com/
 */
class InventoryRepositoryTest extends KernelTestCase
{
    private const TOTALITEMS = 10;

    /**
     * Entity manager
     *
     * @var ObjectManager
     */
    private $_entityManager;

    /**
     * Setup function for test
     *
     * @return void;
     */
    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->_entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * Insert Dummy Data to inventory
     *
     * @return int
     */
    private function _insertInventory(): int
    {
        $totalQuantities = 0;

        for ($i = 0; $i < self::TOTALITEMS; $i++) {
            $inventory = new Inventory();
            $inventory->setQuantity(100);
            $inventory->setPrice(10);
            $inventory->setRemaining(100);
            $this->_entityManager->persist($inventory);
            $this->_entityManager->flush();

            $totalQuantities = $totalQuantities + 100;
        }

        return $totalQuantities;
    }

    /**
     * Test Dropping all entry from database
     *
     * @return void
     */
    public function testDropAll(): void
    {
        $this->_insertInventory();
        $this->_entityManager
            ->getRepository(Inventory::class)
            ->dropAll();
        $inventories = $this->_entityManager
            ->getRepository(Inventory::class)
            ->findAll();
        $this->assertEmpty($inventories);
    }

    /**
     * Test total count of remaining inventory
     *
     * @return void
     */
    public function testGetTotalRemainingItems(): void
    {
        $this->_insertInventory();
        $totalFromDB = $this->_entityManager
            ->getRepository(Inventory::class)
            ->getTotalRemainingItems();

        $this->assertNotNull($totalFromDB);
    }

    /**
     * Test of data insertion in inventory table
     *
     * @return void
     */
    public function testInsertDataToInventory(): void
    {
        $inventory = new Inventory();
        $inventory->setPrice(100);
        $inventory->setQuantity(100);
        $inventory->setRemaining(100);

        $this->_entityManager->persist($inventory);
        $this->_entityManager->flush();

        $inventoryFromDB = $this
            ->_entityManager
            ->getRepository(Inventory::class)
            ->findAll();

        $this->assertNotNull($inventoryFromDB);

        foreach ($inventoryFromDB as $item) {
            $this->assertEquals($item->getPrice(), 100);
            $this->assertEquals($item->getQuantity(), 100);
            $this->assertEquals($item->getRemaining(), 100);
        }
    }



    /**
     * Tear Down the test
     *
     * @return void
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        $this->_entityManager->close();
        $this->_entityManager = null;
    }
}
