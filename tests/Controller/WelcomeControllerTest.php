<?php
/**
 * Test codes for index page
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
 * Class WelcomeControllerTest
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
class WelcomeControllerTest extends WebTestCase
{

    /**
     * Test function for index route
     *
     * @return null
     */
    public function testIndexRouteIsWorking()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorExists('.profit_amount');
        $this->assertSelectorTextContains('.navbar-brand', 'Margin Calculator');

        return null;
    }

    /**
     * Test function for links and contents at home page
     *
     * @return null
     */
    public function testLinksAndContentsAreAvailable()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertStringContainsString(
            'Inventory',
            $client->getResponse()->getContent()
        );
        $this->assertStringContainsString(
            'Sells',
            $client->getResponse()->getContent()
        );
        $this->assertStringContainsString(
            'Reset',
            $client->getResponse()->getContent()
        );
        $this->assertStringContainsString(
            'Total Profit',
            $client->getResponse()->getContent()
        );

        return null;
    }

    /**
     * Test function for website title
     *
     * @return null
     */
    public function testWelcomeTitleShouldBeMarginCalculator()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertSelectorTextContains('title', 'Margin Calculator');

        return null;
    }

    /**
     * Test function for inventory list link
     *
     * @return null
     */
    public function testInventoryListLinkClick()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $client->clickLink("Inventory List");

        $this->assertStringContainsStringIgnoringCase(
            "Inventory List",
            $client->getResponse()->getContent()
        );

        return null;
    }

    /**
     * Test function for new purchase link
     *
     * @return null
     */
    public function testNewPurchaseLinkClick()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $client->clickLink("Add New Purchase");

        $this->assertStringContainsString(
            'Add a purchase',
            $client->getResponse()->getContent()
        );

        return null;
    }

    /**
     * Test code for sell list link
     *
     * @return null
     */
    public function testSellListLinkClick()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $client->clickLink('Sells List');

        $this->assertStringContainsString(
            'Sell List',
            $client->getResponse()->getContent()
        );

        return null;
    }

    /**
     * Test function for new purchase link
     *
     * @return null
     */
    public function testNewSellLinkClick()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $client->clickLink("Add New Sell");

        $this->assertStringContainsString(
            'Add a Sell',
            $client->getResponse()->getContent()
        );

        return null;
    }

    /**
     * Test reset link is working
     *
     * @return null
     */
    public function testResetLinkWorking()
    {
        $client = static::createClient();
        $client->request("GET", '/');
        $client->clickLink('Reset');

        $this->assertResponseRedirects('/');

        return null;
    }

    /**
     * Test code for calculating final profit
     *
     * @return void
     */
    public function testCalculateFinalProfit() : void
    {
        $client = static::createClient();
        $client->request('GET', '/purchase/add');
        $client->submitForm(
            'Add Purchase',
            [
                'purchase[quantity]' => 10,
                'purchase[price]' => 17
            ]
        );
        $client->request('GET', '/sell/add');
        $client->submitForm(
            'Add Sell',
            [
                'sell[quantity]' => 6,
                'sell[price]' => 21
            ]
        );
        $client->request('GET', '/purchase/add');
        $client->submitForm(
            'Add Purchase',
            [
                'purchase[quantity]' => 10,
                'purchase[price]' => 20
            ]
        );
        $client->request('GET', '/sell/add');
        $client->submitForm(
            'Add Sell',
            [
                'sell[quantity]' => 8,
                'sell[price]' => 23
            ]
        );
        $client->request('GET', '/');

        $this->assertSelectorTextContains('.total-profit', '60');
    }
}
