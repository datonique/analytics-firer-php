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
        $page_view = new PageView(
            'test_page_html',
            'test_page_php_class_name',
            'test_page_url'
        );
        $page_view->setSession(new Session());
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
        $page_view->setSession(new Session());
        $out_array = $page_view->toOutArray();
        $this->assertTrue(SessionTestHelper::testSessionInfoForAnalytic($out_array));
        $this->assertEquals($out_array['event_name'], 'button_click');
        $this->assertEquals($out_array['button_name'], 'test_button');
        $this->assertEquals($out_array['html_page_title'], 'test_page_html');
        $this->assertEquals($out_array['page_php_class_name'], 'test_page_php_class_name');
        $this->assertEquals($out_array['page_url'], 'test_page_url');
    }
}

class SessionTestHelper
{
    public static function testSessionInfoForAnalytic($out_array) 
    {
        return (isset($out_array['unix_timestamp']) && 
            isset($out_array['session_id']));
    }
}