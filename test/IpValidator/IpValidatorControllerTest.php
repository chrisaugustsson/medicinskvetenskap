<?php

namespace Anax\IpValidator;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the FlatFileContentController.
 */
class RestApiControllerTest extends TestCase
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
        $this->controller = new IpValidatorController();
        $this->controller->setDI($this->di);
        //$this->controller->initialize();
    }

    /**
     * Test the route "index".
     */
    public function testIndexAction()
    {
        $request = $this->di->get("request");
        $res = $this->controller->indexActionGet();
        $body = $res->getBody();

        $exp = "Validate IP";
        $this->assertContains($exp, $body);
    }


    /**
     * Test the route "validate" with valid IPv6 address.
     */
    public function testWithValidIpv6ValidateAction()
    {
        $request = $this->di->get("request");
        $request->setGlobals([
            "post" => [
                "ipAddress" => "2001:db8:85a3:0:0:8a2e:370:7334"
            ]
        ]);
        $res = $this->controller->validateActionPost();
        $body = $res->getBody();

        $exp = "This is a valid IPv6 address!";
        $this->assertContains($exp, $body);
    }


    /**
     * Test the route "validate" with valid IPv4 address.
     */
    public function testWithValidIpv4ValidateAction()
    {
        $request = $this->di->get("request");
        $request->setGlobals([
            "post" => [
                "ipAddress" => "127.255.255.255"
            ]
        ]);
        $res = $this->controller->validateActionPost();
        $body = $res->getBody();

        $exp = "This is a valid IPv4 address!";
        $this->assertContains($exp, $body);
    }

    /**
     * Test the route "validate" with invalid IP address.
     */
    public function testWithInvalidIpValidateAction()
    {
        $request = $this->di->get("request");
        $request->setGlobals([
            "post" => [
                "ipAddress" => "127.25a5.255.255"
            ]
        ]);
        $res = $this->controller->validateActionPost();
        $body = $res->getBody();

        $exp = "No valid IP address entered";
        $this->assertContains($exp, $body);
    }
}
