<?php

namespace datonique\AnalyticsFirerTest;

use datonique\AnalyticsFirer;
use datonique\Session\Cookie;
use datonique\Session\Session;
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
        $analytics_firer = AnalyticsFirerHelper::createSuccessClient(1, $this->createMock(Cookie::class), true);
        $this->assertInstanceOf('datonique\AnalyticsFirer', $analytics_firer);
    }

    /**
     * Test firing of ButtonClick
     */
    public function testFireEventButtonClick()
    {
        $analytics_firer = AnalyticsFirerHelper::createSuccessClient(
            1, 
            AnalyticsFirerHelper::getMockCookieWithSession(
                $this->createMock(Cookie::class)),
            true);
        $analytics_firer->buttonClick('test_button', AnalyticsFirerHelper::getTestPageInfo());
        $this->assertEquals(1, $analytics_firer->checkSuccess());
        $this->assertEquals(0, $analytics_firer->checkQueue());
    }

    /**
     * Test firing of PageView
     */
    public function testFireEventPageView()
    {
        $analytics_firer = AnalyticsFirerHelper::createSuccessClient(
            1, 
            AnalyticsFirerHelper::getMockCookieWithSession(
                $this->createMock(Cookie::class)),
            true);
        $analytics_firer->pageView(AnalyticsFirerHelper::getTestPageInfo());
        $this->assertEquals(1, $analytics_firer->checkSuccess());
        $this->assertEquals(0, $analytics_firer->checkQueue());
    }

    /**
     * Test firing of Subscription Event
     */
    public function testFireEventSubscriptionCancelled()
    {
        $analytics_firer = AnalyticsFirerHelper::createSuccessClient(
            1, 
            AnalyticsFirerHelper::getMockCookieWithSession(
                $this->createMock(Cookie::class)),
            false);
        // TODO: check here
        $analytics_firer->subscriptionCancelled(array(), array());
        $this->assertEquals(1, $analytics_firer->checkSuccess());
        $this->assertEquals(0, $analytics_firer->checkQueue());
    }

    public function testFireEventFreeTrialCancelled()
    {
        $analytics_firer = AnalyticsFirerHelper::createSuccessClient(
            1, 
            AnalyticsFirerHelper::getMockCookieWithSession(
                $this->createMock(Cookie::class)),
            false);
        // TODO: check here
        $analytics_firer->freeTrialCancelled(array(), array());
        $this->assertEquals(1, $analytics_firer->checkSuccess());
        $this->assertEquals(0, $analytics_firer->checkQueue());
    }

    public function testFireEventSubscriptionStart()
    {
        $analytics_firer = AnalyticsFirerHelper::createSuccessClient(
            1, 
            AnalyticsFirerHelper::getMockCookieWithSession(
                $this->createMock(Cookie::class)),
            false);
        // TODO: check here
        $analytics_firer->subscriptionStart(array(), array());
        $this->assertEquals(1, $analytics_firer->checkSuccess());
        $this->assertEquals(0, $analytics_firer->checkQueue());
    }

    public function testFireEventSubscriptionRenewed()
    {
        $analytics_firer = AnalyticsFirerHelper::createSuccessClient(
            1, 
            AnalyticsFirerHelper::getMockCookieWithSession(
                $this->createMock(Cookie::class)),
            false);
        // TODO: check here
        $analytics_firer->subscriptionRenewed(array(), array());
        $this->assertEquals(1, $analytics_firer->checkSuccess());
        $this->assertEquals(0, $analytics_firer->checkQueue());
    }

    public function testFireEventFreeTrialStart()
    {
        $analytics_firer = AnalyticsFirerHelper::createSuccessClient(
            1, 
            AnalyticsFirerHelper::getMockCookieWithSession(
                $this->createMock(Cookie::class)),
            false);
        // TODO: check here
        $analytics_firer->freeTrialStart(array(), array());
        $this->assertEquals(1, $analytics_firer->checkSuccess());
        $this->assertEquals(0, $analytics_firer->checkQueue());
    }

    public function testFireEventRegistrationSucceeded() 
    {
        $analytics_firer = AnalyticsFirerHelper::createSuccessClient(
            1, 
            AnalyticsFirerHelper::getMockCookieWithSession(
                $this->createMock(Cookie::class)),
            false);
        // TODO: check here
        $analytics_firer->registrationSucceeded(array(), AnalyticsFirerHelper::getTestPageInfo());
        $this->assertEquals(1, $analytics_firer->checkSuccess());
        $this->assertEquals(0, $analytics_firer->checkQueue());
    }

    public function testFireEventRegistrationFailed() 
    {
        $analytics_firer = AnalyticsFirerHelper::createSuccessClient(
            1, 
            AnalyticsFirerHelper::getMockCookieWithSession(
                $this->createMock(Cookie::class)),
            false);
        // TODO: check here
        $analytics_firer->registrationFailed(AnalyticsFirerHelper::getTestPageInfo());
        $this->assertEquals(1, $analytics_firer->checkSuccess());
        $this->assertEquals(0, $analytics_firer->checkQueue());
    }

    public function testFireEventInquisitionEnd() 
    {
        $analytics_firer = AnalyticsFirerHelper::createSuccessClient(
            1, 
            AnalyticsFirerHelper::getMockCookieWithSession(
                $this->createMock(Cookie::class)),
            false);
        // TODO: check here
        $analytics_firer->inquisitionEnd(array(), array(), AnalyticsFirerHelper::getTestPageInfo());
        $this->assertEquals(1, $analytics_firer->checkSuccess());
        $this->assertEquals(0, $analytics_firer->checkQueue());
    }

    public function testFireEventInquisitionProgress() 
    {
        $analytics_firer = AnalyticsFirerHelper::createSuccessClient(
            1, 
            AnalyticsFirerHelper::getMockCookieWithSession(
                $this->createMock(Cookie::class)),
            false);
        // TODO: check here
        $analytics_firer->inquisitionProgress(array(), array(), AnalyticsFirerHelper::getTestPageInfo());
        $this->assertEquals(1, $analytics_firer->checkSuccess());
        $this->assertEquals(0, $analytics_firer->checkQueue());
    }

    /**
     * Test fail event ButtonClick
     */
    public function testFireEventButtonClickFailed()
    {
        $analytics_firer = AnalyticsFirerHelper::createFailureClient(
            1, 
            AnalyticsFirerHelper::getMockCookieWithSession(
                $this->createMock(Cookie::class)),
            true);
        $analytics_firer->buttonClick('test_button', AnalyticsFirerHelper::getTestPageInfo());
        $this->assertEquals(0, $analytics_firer->checkSuccess());
        $this->assertEquals(0, $analytics_firer->checkQueue());
        $this->assertEquals(1, $analytics_firer->checkFailed());
    }

    /**
     * Test fail event PageView
     */
    public function testFireEventPaigeViewFailed()
    {
        $analytics_firer = AnalyticsFirerHelper::createFailureClient(
            1, 
            AnalyticsFirerHelper::getMockCookieWithSession(
                $this->createMock(Cookie::class)),
            true);

        $analytics_firer->pageView(AnalyticsFirerHelper::getTestPageInfo());
        $this->assertEquals(0, $analytics_firer->checkSuccess());
        $this->assertEquals(0, $analytics_firer->checkQueue());
        $this->assertEquals(1, $analytics_firer->checkFailed());
    }

    public function testOath2ProverFails()
    {
        $this->expectException(Exception);
        new AnalyticsFirer([
            'base_uri' => '/',
            'batch_size' => 1, // to fire right away
            'max_queue_size' => 1, // to fire right away
            'product_shortname' => 'test_name',
            'product_description' => 'test_description',
            // just for testing
            'client_id' => 'XXXX',
            'client_secret' => 'XXXX'
        ]);
    }
}

class AnalyticsFirerHelper extends TestCase
{
    public static function createSuccessClient(int $num_successes, Cookie $cookie, bool $is_user_session) {
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
            'product_shortname' => 'test_name',
            'product_description' => 'test_description',
            // just for testing
            'handler' => $handlerStack,
            'client_id' => 'XXXX',
            'client_secret' => 'XXXX',

            'mock_cookie' => $cookie,
            'api_key' => 'XXX',
            'is_user_session' => $is_user_session
        ]);
    }

    public static function createFailureClient(int $num_failures, Cookie $cookie, bool $is_user_session) {
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
            'product_shortname' => 'test_name',
            'product_description' => 'test_description',
            // just for testing
            'handler' => $handlerStack,
            'client_id' => 'XXXX',
            'client_secret' => 'XXXX',

            'mock_cookie' => $cookie,
            'api_key' => 'XXX',
            'is_user_session' => $is_user_session
        ]);
    }

    public static function getMockCookieWithSession(Cookie $mock_cookie) 
    {
        $mock_cookie->method('getCookie')
            ->willReturn('ID');
        return $mock_cookie;
    }

    public static function getTestPageInfo()
    {
        return array(
            'html_page_title' =>'test_page_html',   
            'page_php_class_name' => 'test_page_php_class_name',    
            'page_url' => 'test_page_url'   
        );
    }
}