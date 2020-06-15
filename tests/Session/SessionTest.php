<?php

namespace datonique\Session\SessionTest;

use PHPUnit\Framework\TestCase;
use datonique\Analytic\ButtonClick;
use datonique\Analytic\PageView;
use datonique\Session\Session;
use datonique\Session\Cookie;
/**
 * AnalyticsFirerTest Class
 *
 * @author George Torres <george@datonique.com>
 */
class SessionTest extends TestCase 
{
    /**
     * Setup Method
     *
     */
    public function setUp()
    {

    }

    public function testCreateSession()
    {
        $this->assertEquals(0, 0);
    }

    // TODO: test cookie expire
    // TODO: session id creation
    // TOOD: browser and OS versions

}