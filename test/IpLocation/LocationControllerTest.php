<?php

namespace Anax\IpLocation;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the FlatFileContentController.
 */
class LocationControllerTest extends TestCase
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
        $this->controller = new LocationController();
        $this->controller->setDI($this->di);
        //$this->controller->initialize();

        //Clear cache
        $cache = $di->get("cache");
        $cache->delete("httpapiipstackcom127255255255accesskey76d2dc7dd12afedf6fc8bf90e2a75e26");
    }

    /**
     * Test the route "index".
     */
    public function testIndexAction()
    {
        $request = $this->di->get("request");
        $res = $this->controller->indexActionGet();
        $body = $res->getBody();

        $exp = "Position from IP";
        $this->assertContains($exp, $body);
    }


    /**
     * Test the route "locate" with valid IP address.
     */
    public function testWithValidIpv6ValidateAction()
    {
        $request = $this->di->get("request");
        $request->setGet("ip", "127.255.255.255");
        $res = $this->controller->locateActionGet();
        $body = $res->getBody();

        $exp = "ipv4";
        $this->assertContains($exp, $body);

        // Same request once more to fetch from cache instead
        $request = $this->di->get("request");
        $request->setGet("ip", "127.255.255.255");
        $res = $this->controller->locateActionGet();
        $body = $res->getBody();

        $exp = "ipv4";
        $this->assertContains($exp, $body);

        //Clear cache when done
        $cache = $this->di->get("cache");
        $cache->delete("127.255.255.255");
    }


    /**
     * Test the route "locate" with invalid IP address.
     */
    public function testWithInvalidIpValidateAction()
    {
        $request = $this->di->get("request");
        $request->setGet("ip", "127.255.255.2525");
        $res = $this->controller->locateActionGet();
        $body = $res->getBody();

        $exp = "Not a valid IP-address";
        $this->assertContains($exp, $body);
    }
}
