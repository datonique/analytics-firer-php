<?php

namespace datonique\Analytic\AnalyticTest;

use PHPUnit\Framework\TestCase;
use datonique\Analytic\InquisitionEnd;
use datonique\Analytic\InquisitionProgress;
use datonique\Analytic\ButtonClick;
use datonique\Analytic\PageView;
use datonique\Analytic\Registration;
use datonique\Analytic\SessionStart;
use datonique\Analytic\SubscriptionStart;
use datonique\Analytic\SubscriptionCancelled;
use datonique\Analytic\SubscriptionRenewed;
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
            SessionTestHelper::getTestPageInfo()
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
            SessionTestHelper::getTestPageInfo()
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
        $subscription_cancelled = new SubscriptionCancelled(array(), false);
        $cookie = $this->createMock(Cookie::class);
        $cookie->expects($this->once())->method('setCookie');
        $subscription_cancelled->setSession(new Session($cookie, 'test_name', 'test_description'));
        $out_array = $subscription_cancelled->toOutArray();
        $this->assertTrue(SessionTestHelper::testSessionInfoForAnalytic($out_array));
        $this->assertEquals($out_array['event_name'], 'subscription_end');
        // TODO: subscription cancelled specifics
    }

    public function testSubscriptionStart()
    {
        $subscription_start = new SubscriptionStart(array(), false);
        $cookie = $this->createMock(Cookie::class);
        $cookie->expects($this->once())->method('setCookie');
        $subscription_start->setSession(new Session($cookie, 'test_name', 'test_description'));
        $out_array = $subscription_start->toOutArray();
        $this->assertTrue(SessionTestHelper::testSessionInfoForAnalytic($out_array));
        $this->assertEquals($out_array['event_name'], 'subscription_start');
        // TODO: subscription cancelled specifics
    }

    public function testSubscriptionRenewed()
    {
        $subscription_renewed = new SubscriptionRenewed(array());
        $cookie = $this->createMock(Cookie::class);
        $cookie->expects($this->once())->method('setCookie');
        $subscription_renewed->setSession(new Session($cookie, 'test_name', 'test_description'));
        $out_array = $subscription_renewed->toOutArray();
        $this->assertTrue(SessionTestHelper::testSessionInfoForAnalytic($out_array));
        $this->assertEquals($out_array['event_name'], 'subscription_renewed');
        // TODO: subscription cancelled specifics
    }

    public function testFreeTrialCancelled()
    {
        $free_trial = new SubscriptionCancelled(array(), true);
        $cookie = $this->createMock(Cookie::class);
        $cookie->expects($this->once())->method('setCookie');
        $free_trial->setSession(new Session($cookie, 'test_name', 'test_description'));
        $out_array = $free_trial->toOutArray();
        $this->assertTrue(SessionTestHelper::testSessionInfoForAnalytic($out_array));
        $this->assertEquals($out_array['event_name'], 'free_trial_end');
        // TODO: subscription cancelled specifics
    }

    public function testFreeTrialStart()
    {
        $subscription_start = new SubscriptionStart(array(), true);
        $cookie = $this->createMock(Cookie::class);
        $cookie->expects($this->once())->method('setCookie');
        $subscription_start->setSession(new Session($cookie, 'test_name', 'test_description'));
        $out_array = $subscription_start->toOutArray();
        $this->assertTrue(SessionTestHelper::testSessionInfoForAnalytic($out_array));
        $this->assertEquals($out_array['event_name'], 'free_trial_start');
        // TODO: subscription cancelled specifics
    }

    public function testInquisitionEnd()
    {
        $page_view = new InquisitionEnd(array(), array(), SessionTestHelper::getTestPageInfo());
        $cookie = $this->createMock(Cookie::class);
        $cookie->expects($this->once())->method('setCookie');
        $page_view->setSession(new Session($cookie, 'test_name', 'test_description'));
        $out_array = $page_view->toOutArray();
        // echo print_r($out_array);
        $this->assertTrue(SessionTestHelper::testSessionInfoForAnalytic($out_array));
        $this->assertEquals($out_array['event_name'], 'inquisition_end');
        $this->assertEquals($out_array['html_page_title'], 'test_page_html');
        $this->assertEquals($out_array['page_php_class_name'], 'test_page_php_class_name');
        $this->assertEquals($out_array['page_url'], 'test_page_url');
    }

    public function testInquisitionProgress()
    {
        $page_view = new InquisitionProgress(array(), array(), SessionTestHelper::getTestPageInfo());
        $cookie = $this->createMock(Cookie::class);
        $cookie->expects($this->once())->method('setCookie');
        $page_view->setSession(new Session($cookie, 'test_name', 'test_description'));
        $out_array = $page_view->toOutArray();
        $this->assertTrue(SessionTestHelper::testSessionInfoForAnalytic($out_array));
        $this->assertEquals($out_array['event_name'], 'inquisition_progress');
        $this->assertEquals($out_array['html_page_title'], 'test_page_html');
        $this->assertEquals($out_array['page_php_class_name'], 'test_page_php_class_name');
        $this->assertEquals($out_array['page_url'], 'test_page_url');
        // TODO: subscription cancelled specifics
    }

    public function testRegistrationSucceeded()
    {
        $page_view = new Registration(true, SessionTestHelper::getTestPageInfo());
        $cookie = $this->createMock(Cookie::class);
        $cookie->expects($this->once())->method('setCookie');
        $page_view->setSession(new Session($cookie, 'test_name', 'test_description'));
        $out_array = $page_view->toOutArray();
        $this->assertTrue(SessionTestHelper::testSessionInfoForAnalytic($out_array));
        $this->assertEquals($out_array['event_name'], 'registration_succeeded');
        $this->assertEquals($out_array['html_page_title'], 'test_page_html');
        $this->assertEquals($out_array['page_php_class_name'], 'test_page_php_class_name');
        $this->assertEquals($out_array['page_url'], 'test_page_url');
        // TODO: subscription cancelled specifics
    }

    public function testRegistrationFailed()
    {
        $page_view = new Registration(false, SessionTestHelper::getTestPageInfo());
        $cookie = $this->createMock(Cookie::class);
        $cookie->expects($this->once())->method('setCookie');
        $page_view->setSession(new Session($cookie, 'test_name', 'test_description'));
        $out_array = $page_view->toOutArray();
        $this->assertTrue(SessionTestHelper::testSessionInfoForAnalytic($out_array));
        $this->assertEquals($out_array['event_name'], 'registration_failed');
        $this->assertEquals($out_array['html_page_title'], 'test_page_html');
        $this->assertEquals($out_array['page_php_class_name'], 'test_page_php_class_name');
        $this->assertEquals($out_array['page_url'], 'test_page_url');
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

    public static function getTestPageInfo()
    {
        return array(
            'html_page_title' => 'test_page_html',   
            'page_php_class_name' => 'test_page_php_class_name',    
            'page_url' => 'test_page_url'   
        );
    }
}