<?php

namespace datonique\Analytic\AnalyticTest;

use PHPUnit\Framework\TestCase;
use datonique\Analytic\ButtonClick;
use datonique\Analytic\PageView;
use datonique\Session\Session;
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
        $page_view = new PageView('test_page');
        $page_view->setSession(new Session());
        $out_array = $page_view->toOutArray();
        $this->assertTrue(SessionTestHelper::testSessionInfoForAnalytic($out_array));
        $this->assertEquals($out_array['event_name'], 'PAGE VIEW');
        $this->assertEquals($out_array['page_name'], 'test_page');
    }

    public function testButtonClick()
    {
        $page_view = new ButtonClick('test_button', 'test_page');
        $page_view->setSession(new Session());
        $out_array = $page_view->toOutArray();
        $this->assertTrue(SessionTestHelper::testSessionInfoForAnalytic($out_array));
        $this->assertEquals($out_array['event_name'], 'BUTTON CLICK');
        $this->assertEquals($out_array['button_name'], 'test_button');
        $this->assertEquals($out_array['page_name'], 'test_page');
    }
}

class SessionTestHelper
{
    public static function testSessionInfoForAnalytic($out_array) 
    {
        return (isset($out_array['timestamp']) && 
            isset($out_array['session_id']));
    }
}