<?php

namespace Anax\Weather;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;
use Anax\Curl\Curl;
use Anax\IpLocation\Ipstack;

/**
 * Test the FlatFileContentController.
 */
class WeatherControllerTest extends TestCase
{
        // Create the di container.
        protected $di;
        protected $controller;



    /**
     * Prepare before each test.
     */
    protected function setUp()
    {
        global $di;

        // Setup di
        $this->di = new DIFactoryConfig();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // View helpers uses the global $di so it needs its value
        $di = $this->di;

        // Setup the controller
        $this->controller = new WeatherController();
        $this->controller->setDI($this->di);
        //$this->controller->initialize();
    }


    public function testindexActionGet()
    {
        $res = $this->controller->indexActionGet();
        $body = $res->getBody();

        $exp = "Forecast from IP";
        $this->assertContains($exp, $body);
    }

    public function testIpActionGet()
    {
        $request = $this->di->get("request");
        $request->setGet("ip", "92.232.60.151");
        $res = $this->controller->ipActionGet();
        $body = $res->getBody();

        $exp = "Weather for Liverpool, United Kingdom";
        $this->assertContains($exp, $body);
    }

    public function testIpActionGetWithValidIPWithoutLocation()
    {
        $request = $this->di->get("request");

        $request->setGet("ip", "127.255.255.255");
        $res = $this->controller->ipActionGet();
        $body = $res->getBody();

        $exp = null;
        $this->assertEquals($exp, $body);
    }

    public function testIpActionGetWithInvalidIP()
    {
        $request = $this->di->get("request");

        $request->setGet("ip", "127.255.200000.255");
        $res = $this->controller->ipActionGet();
        $body = $res->getBody();

        $exp = null;
        $this->assertEquals($exp, $body);
    }

    public function testIpActionGetWithHistorySet()
    {
        $request = $this->di->get("request");
        $request->setGet("ip", "127.255.255.255");
        $request->setGet("history", "true");
        $res = $this->controller->ipActionGet();
        $body = $res->getBody();

        $exp = null;
        $this->assertEquals($exp, $body);
    }

    public function testHistoryAction()
    {
        $request = $this->di->get("request");
        $request->setGet("ip", "92.232.60.151");

        $res = $this->controller->historyActionGet();
        $body = $res->getBody();

        $exp = "Weather, last 30 days, for Liverpool, United Kingdom<";
        $this->assertContains($exp, $body);
    }

    public function testHistoryActionWithInvalidIP()
    {
        $request = $this->di->get("request");
        $request->setGet("ip", "127.255.255.255");

        $res = $this->controller->historyActionGet();
        $body = $res->getBody();

        $exp = null;
        $this->assertEquals($exp, $body);
    }
}