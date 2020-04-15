<?php
/**
 * Test codes for purchase page
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
 * Class PurchaseControllerTest
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
class PurchaseControllerTest extends WebTestCase
{
    /**
     * Test code for add purchase
     *
     * @return void
     */
    public function testAddPurchase(): void
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
        $this->assertResponseRedirects('/inventory');
        $client->request('GET', '/inventory');
        $this->assertStringContainsStringIgnoringCase(
            "100",
            $client->getResponse()->getContent()
        );
    }
}
