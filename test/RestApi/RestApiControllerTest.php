<?php

namespace Anax\RestApi;

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
        $this->controller = new RestApiController();
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

        $exp = "API Documentation";
        $this->assertContains($exp, $body);
    }


    /**
     * Test  IpAction.
     */
    public function testIpAction()
    {
        $request = $this->di->get("request");
        $request->setGlobals([
            "post" => [
                "ipAddress" => "2001:db8:85a3:0:0:8a2e:370:7334"
            ]
        ]);
        $res = $this->controller->ipActionPost();

        $ip = $res[0]["ip"];

        $exp = "2001:db8:85a3:0:0:8a2e:370:7334";
        $this->assertContains($exp, $ip);
    }

    /**
     * Test ipLocationActionGet with valid IP.
     */
    public function testIpLocationActionGet()
    {
        $request = $this->di->get("request");

        $res = $this->controller->ipLocationActionGet("127.255.255.255");

        $ip = $res[0]["ip"];
        $type = $res[0]["type"];

        $exp = "127.255.255.255";
        $this->assertContains($exp, $ip);

        $exp = "ipv4";
        $this->assertContains($exp, $type);
    }

    /**
     * Test ipLocationActionGet with invalid IP.
     */
    public function testInvalidIpLocationActionGet()
    {
        $request = $this->di->get("request");

        $res = $this->controller->ipLocationActionGet("127.255.255.2552");

        $ip = $res[0]["ip"];
        $type = $res[0]["type"];

        $exp = "127.255.255.255";
        $this->assertContains($exp, $ip);

        $exp = "Not valid";
        $this->assertContains($exp, $type);
    }


    /**
     * Test the weather function
     */
    public function testWeather()
    {
        $request = $this->di->get("request");

        $res = $this->controller->currentForecastActionGet("127.255.255.2552");

        $ip = $res[0]["ip"];
        $type = $res[0]["type"];

        $exp = "127.255.255.255";
        $this->assertContains($exp, $ip);

        $exp = "Not valid";
        $this->assertContains($exp, $type);


        $res = $this->controller->currentForecastActionGet("127.255.255.255");
        $exp = "Not valid";
        $this->assertContains($exp, $type);
    }

    /**
     * Test the weather function
     */
    public function testWeatherHistory()
    {
        $request = $this->di->get("request");

        $res = $this->controller->historyForecastActionGet("127.255.255.2552");

        $ip = $res[0]["ip"];
        $type = $res[0]["type"];

        $exp = "127.255.255.255";
        $this->assertContains($exp, $ip);

        $exp = "Not valid";
        $this->assertContains($exp, $type);


        $res = $this->controller->historyForecastActionGet("127.255.255.2552");
        $exp = "Not valid";
        $this->assertContains($exp, $type);

        $res = $this->controller->historyForecastActionGet("92.232.60.151");

        $country = $res[0]["country"];

        $exp = "United Kingdom";
        $this->assertContains($exp, $country);
    }
}
