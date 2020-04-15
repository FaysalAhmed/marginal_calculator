<?php
/**
 * ProfitCalculatorTest.php
 *
 * PHP version 7
 *
 * @category Tests
 *
 * @package App\Tests\service
 *
 * @author Faysal Ahmed <faysal.ahmed833@gmail.com>
 *
 * @license custom license http://www.eskimi.com/
 *
 * @link http://www.eskimi.com/
 */

namespace App\Tests\Service;

use App\Entity\Inventory;
use App\Entity\Sell;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * ProfitCalculatorTest Class
 *
 * PHP version 7
 *
 * @category Tests
 *
 * @package App\Tests\Service
 *
 * @author Faysal Ahmed <faysal.ahmed833@gmail.com>
 *
 * @license custom license http://www.eskimi.com/
 *
 * @link http://www.eskimi.com/
 */
class ProfitCalculatorTest extends KernelTestCase
{
    private $_profitCalculator;
    private $_entityManager;

    /**
     * SetUp function for test
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
        $this->_profitCalculator = $container->get("App\Service\ProfitCalculator");
    }

    /**
     * Test calculation
     *
     * @return void
     */
    public function testCalculate(): void
    {
        $inventory = new Inventory();
        $inventory->setPrice(17);
        $inventory->setQuantity(10);
        $this->_entityManager->persist($inventory);
        $this->_entityManager->flush();

        $sell = new Sell();
        $sell->setQuantity(6);
        $sell->setPrice(21);
        $profit = $this->_profitCalculator->calculate($sell, $this->_entityManager);
        $this->assertEquals($profit, 24);
    }
}
