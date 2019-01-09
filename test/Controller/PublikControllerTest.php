<?php

namespace Anax\Publik;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the FlatFileContentController.
 */
class PublikControllerTest extends TestCase
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
        $this->controller = new PublikController();
        $this->controller->setDI($this->di);
        //$this->controller->initialize();
    }

    /**
     * Test the route "index".
     */
    public function testIndexAction()
    {
        $res = $this->controller->indexActionGet();
        $body = $res->getBody();

        $exp = "Senaste inläggen:";
        $this->assertContains($exp, $body);
    }

    /**
     * Test the route "tradar".
     */
    public function testTradarAction()
    {
        $res = $this->controller->tradarActionGet();
        $body = $res->getBody();

        $exp = "Sortera efter:";
        $this->assertContains($exp, $body);
    }

    /**
     * Test the route "taggar".
     */
    public function testTaggarAction()
    {
        $res = $this->controller->taggarActionGet();
        $body = $res->getBody();

        $exp = "content columns is-multiline";
        $this->assertContains($exp, $body);
    }

    /**
     * Test the route "tag".
     */
    public function testTagAction()
    {
        $res = $this->controller->tagActionGet("ortopedi");
        $body = $res->getBody();

        $exp = "Trådar med taggen";
        $this->assertContains($exp, $body);
    }
}
