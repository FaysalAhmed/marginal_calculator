<?php
/**
 * Test codes for sells page
 *
 * PHP version 7
 *
 * @category Test
 *
 * @package App\Tests\Controller
 *
 * @author Faysal Ahmed <faysal.ahmed833@gmail.com>
 *
 * @license custom license http://www.eskimi.com/
 *
 * @link http://www.eskimi.com/
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class SellControllerTest
 *
 * @category Test
 *
 * @package App\Tests\Controller
 *
 * @author Faysal Ahmed <faysal.ahmed833@gmail.com>
 *
 * @license custom license http://www.eskimi.com/
 *
 * @link http://www.eskimi.com/
 */
class SellControllerTest extends WebTestCase
{
    /**
     * Test add sell post method
     *
     * @return void
     */
    public function testAddSell(): void
    {
        $client = static::createClient();
        $client->request('GET', '/purchase/add');
        $client->submitForm(
            'Add Purchase',
            [
                'purchase[quantity]' => 100,
                'purchase[price]' => 100
            ]
        );
        $client->request('GET', '/sell/add');
        $client->submitForm(
            'Add Sell',
            [
                'sell[quantity]' =>30,
                'sell[price]' => 100
            ]
        );
        $this->assertResponseRedirects('/sell');
        $client->request('GET', '/sell');
        $this->assertStringContainsString(
            '100',
            $client->getResponse()->getContent()
        );
    }
}
