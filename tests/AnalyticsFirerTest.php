<?php

namespace datonique\AnalyticsFirerTest;

use datonique\AnalyticsFirer;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Tests\Server;
use PHPUnit\Framework\TestCase;

/**
 * AnalyticsFirerTest Class
 *
 * @author George Torres <george@datonique.com>
 */
class AnalyticsFirerTest extends TestCase
{

    /**
     * @var AnalyticsFirer $client
     */
    protected $analytics_firer;

    /**
     * Setup Method
     */
    public function setUp()
    {
        // TODO: Config


    }

    /**
     * Testing the AnalyticsFirer::__construct() method
     */
    public function testConstructor()
    {
        $analytics_firer = AnalyticsFirerHelper::createSuccessClient(1);
        $this->assertInstanceOf('datonique\AnalyticsFirer', $analytics_firer);
    }

    /**
     * Test firing of ButtonClick
     */
    public function testFireEventButtonClick()
    {
        $analytics_firer = AnalyticsFirerHelper::createSuccessClient(1);
        $analytics_firer->buttonClick('test_button', 'test_page', 'test_page', 'test_page');
        $this->assertEquals(1, $analytics_firer->checkSuccess());
        $this->assertEquals(0, $analytics_firer->checkQueue());
    }

    /**
     * Test firing of PageView
     */
    public function testFireEventPageView()
    {
        $analytics_firer = AnalyticsFirerHelper::createSuccessClient(1);
        $analytics_firer->pageView('test_page', 'test_page', 'test_page');
        $this->assertEquals(1, $analytics_firer->checkSuccess());
        $this->assertEquals(0, $analytics_firer->checkQueue());
    }

    /**
     * Test fail event ButtonClick
     */
    public function testFireEventButtonClickFailed()
    {
        $analytics_firer = AnalyticsFirerHelper::createFailureClient(1);
        $analytics_firer->buttonClick('test_button', 'test_page', 'test_page', 'test_page');
        $this->assertEquals(0, $analytics_firer->checkSuccess());
        $this->assertEquals(0, $analytics_firer->checkQueue());
        $this->assertEquals(1, $analytics_firer->checkFailed());
    }

    /**
     * Test fail event PageView
     */
    public function testFireEventPaigeViewFailed()
    {
        $analytics_firer = AnalyticsFirerHelper::createFailureClient(1);
        $analytics_firer->pageView('test_page', 'test_page', 'test_page');
        $this->assertEquals(0, $analytics_firer->checkSuccess());
        $this->assertEquals(0, $analytics_firer->checkQueue());
        $this->assertEquals(1, $analytics_firer->checkFailed());
    }
}

class AnalyticsFirerHelper 
{
    public static function createSuccessClient(int $num_successes) {
        // Create a mock and queue two responses.
        // TODO: do by number of failures
        $mock = new MockHandler([
            new Response(200)
        ]);

        $handlerStack = HandlerStack::create($mock);

        return new AnalyticsFirer([
            'base_uri' => '/',
            'batch_size' => 1, // to fire right away
            'max_queue_size' => 1, // to fire right away
            // just for testing
            'handler' => $handlerStack,
            'client_id' => 'XXXX',
            'client_secret' => 'XXXX'
        ]);
    }

    public static function createFailureClient(int $num_failures) {
        // Create a mock and queue two responses.
        // TODO: do by number of failures
        $mock = new MockHandler([
            new Response(404)
        ]);

        $handlerStack = HandlerStack::create($mock);

        return new AnalyticsFirer([
            'base_uri' => '/',
            'batch_size' => 1, // to fire right away
            'max_queue_size' => 1, // to fire right away
            // just for testing
            'handler' => $handlerStack,
            'client_id' => 'XXXX',
            'client_secret' => 'XXXX'
        ]);
    }
}