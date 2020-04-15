<?php
/**
 * Test file for  Sell Repository
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
use App\Entity\Sell;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Test Class for  Sell Repository
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
class SellRepositoryTest extends KernelTestCase
{
    private const TOTALITEMS = 10;
    private $_entityManager;
    private $_profitCalculator;

    /**
     * Setup function for test
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $kernel = self::bootKernel();
        $this->_entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $container = self::$container;
        $this->_profitCalculator = $container
            ->get("App\Service\ProfitCalculator");
    }

    /**
     * Insert sells to test
     *
     * @return int total profit
     */
    private function _insertSell(): int
    {
        $totalProfit = 0;
        for ($i = 0; $i < self::TOTALITEMS; $i++) {
            $sell = new Sell();
            $sell->setQuantity(100);
            $sell->setPrice(100);
            $profit = $this->_profitCalculator
                ->calculate($sell, $this->_entityManager);
            $totalProfit = $totalProfit + $profit;
            $sell->setProfit($profit);
            $this->_entityManager->persist($sell);
            $this->_entityManager->flush();
        }
        return $totalProfit;
    }

    /**
     * Drop all from table
     *
     * @return void
     */
    public function testDropAll(): void
    {
        $this->_insertSell();
        $this->_entityManager
            ->getRepository(Sell::class)
            ->dropAll();
        $sells = $this->_entityManager
            ->getRepository(Sell::class)
            ->findAll();
        $this->assertEmpty($sells);
    }

    /**
     * Test total profit
     *
     * @return void
     */
    public function testGetTotalProfit(): void
    {
        $totalProfit = $this->_insertSell();
        $profit = $this->_entityManager
            ->getRepository(Sell::class)
            ->getTotalProfit();
        $this->assertEquals($totalProfit, $profit);
    }

    /**
     * Test insert data to sell table
     *
     * @return void
     */
    public function testInsertDataToSell(): void
    {
        $inventory = new Inventory();
        $inventory->setPrice(10);
        $inventory->setQuantity(17);
        $this->_entityManager->persist($inventory);
        $this->_entityManager->flush();

        $sell = new Sell();
        $sell->setQuantity(6);
        $sell->setPrice(21);
        $profit = $this->_profitCalculator->calculate($sell, $this->_entityManager);
        $sell->setProfit($profit);
        $this->_entityManager->persist($sell);
        $this->_entityManager->flush();
        $sellFromDB = $this->_entityManager->getRepository(Sell::class)->findAll();
        $this->assertNotNull($sellFromDB);
        foreach ($sellFromDB as $item) {
            $this->assertEquals($item->getPrice(), 21);
            $this->assertEquals($item->getQuantity(), 6);
        }
    }

    /**
     * Tear down the test
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
