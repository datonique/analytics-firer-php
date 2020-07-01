<?php

namespace datonique\Analytic\AnalyticTest;

use PHPUnit\Framework\TestCase;
use datonique\Analytic\ButtonClick;
use datonique\Analytic\PageView;
use datonique\Analytic\SessionStart;
use datonique\Analytic\SubscriptionCancelled;
use datonique\Session\Session;
use datonique\Session\Cookie;
/**
 * AnalyticsFirerTest Class
 *
 * @author George Torres <george@datonique.com>
 */
class AnalyticTest extends TestCase
{
    /**
     * Setup Method
     *
     */
    public function setUp()
    {

    }

    public function testPageView()
    {
        $page_view = new PageView(
            'test_page_html',
            'test_page_php_class_name',
            'test_page_url'
        );
        $cookie = $this->createMock(Cookie::class);
        $cookie->expects($this->once())->method('setCookie');
        $page_view->setSession(new Session($cookie, 'test_name', 'test_description'));
        $out_array = $page_view->toOutArray();
        $this->assertTrue(SessionTestHelper::testSessionInfoForAnalytic($out_array));
        $this->assertEquals($out_array['event_name'], 'pageview');
        $this->assertEquals($out_array['html_page_title'], 'test_page_html');
        $this->assertEquals($out_array['page_php_class_name'], 'test_page_php_class_name');
        $this->assertEquals($out_array['page_url'], 'test_page_url');

    }

    public function testButtonClick()
    {
        $page_view = new ButtonClick(
            'test_button', 
            'test_page_html',
            'test_page_php_class_name',
            'test_page_url'
        );
        $cookie = $this->createMock(Cookie::class);
        $cookie->expects($this->once())->method('setCookie');
        $page_view->setSession(new Session($cookie, 'test_name', 'test_description'));
        $out_array = $page_view->toOutArray();
        $this->assertTrue(SessionTestHelper::testSessionInfoForAnalytic($out_array));
        $this->assertEquals($out_array['event_name'], 'button_click');
        $this->assertEquals($out_array['button_name'], 'test_button');
        $this->assertEquals($out_array['html_page_title'], 'test_page_html');
        $this->assertEquals($out_array['page_php_class_name'], 'test_page_php_class_name');
        $this->assertEquals($out_array['page_url'], 'test_page_url');
    }

    public function testSessionStart()
    {
        $page_view = new SessionStart();
        $cookie = $this->createMock(Cookie::class);
        $cookie->expects($this->once())->method('setCookie');
        $page_view->setSession(new Session($cookie, 'test_name', 'test_description'));
        $out_array = $page_view->toOutArray();
        $this->assertTrue(SessionTestHelper::testSessionInfoForAnalytic($out_array));
        $this->assertEquals($out_array['event_name'], 'session_start');
    }

    public function testSubscriptionCancelled()
    {
        $page_view = new SubscriptionCancelled(array(), false);
        $cookie = $this->createMock(Cookie::class);
        $cookie->expects($this->once())->method('setCookie');
        $page_view->setSession(new Session($cookie, 'test_name', 'test_description'));
        $out_array = $page_view->toOutArray();
        $this->assertTrue(SessionTestHelper::testSessionInfoForAnalytic($out_array));
        $this->assertEquals($out_array['event_name'], 'subscription_end');
        // TODO: subscription cancelled specifics
    }

    public function testFreeTrialCancelled()
    {
        $page_view = new SubscriptionCancelled(array(), true);
        $cookie = $this->createMock(Cookie::class);
        $cookie->expects($this->once())->method('setCookie');
        $page_view->setSession(new Session($cookie, 'test_name', 'test_description'));
        $out_array = $page_view->toOutArray();
        $this->assertTrue(SessionTestHelper::testSessionInfoForAnalytic($out_array));
        $this->assertEquals($out_array['event_name'], 'free_trial_end');
        // TODO: subscription cancelled specifics
    }
}

class SessionTestHelper
{
    public static function testSessionInfoForAnalytic($out_array) 
    {
        return (isset($out_array['unix_timestamp']) && 
            isset($out_array['visitor_session_id']));
    }

    public static function getMockCookie()
    {
        return ;
    }
}