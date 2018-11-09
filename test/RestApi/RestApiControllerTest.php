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
}
