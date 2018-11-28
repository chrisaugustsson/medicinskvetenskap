<?php

namespace Anax\Weather;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;
use Anax\Curl\Curl;
use Anax\IpLocation\Ipstack;

/**
 * Test the FlatFileContentController.
 */
class DarkSkyTest extends TestCase
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

        // Init the modules needed
        $curl = $di->get("curl");
        $cfg = $di->get("configuration");
        $locationProvider = new Ipstack($curl, $cfg);

        // Setup the DarkSky
        $this->darkSky = new DarkSky($locationProvider, $curl, $cfg);
    }


    /**
     *
     */
    public function testgetLocation()
    {
        $this->darkSky->setLocation("92.232.60.151");
        $res = $this->darkSky->getForecast();
        $expCity = "Liverpool";
        $expCountry = "United Kingdom";

        $this->assertEquals($expCity, $res["city"]);
        $this->assertEquals($expCountry, $res["country"]);
    }

    public function testGetOld()
    {
        $this->darkSky->setLocation("92.232.60.151");
        $res = $this->darkSky->getOldCast();
        $expCity = "Liverpool";
        $expCountry = "United Kingdom";

        $this->assertEquals($expCity, $res["city"]);
        $this->assertEquals($expCountry, $res["country"]);

    }

    public function testWithBadIpAddress()
    {
        $this->darkSky->setLocation("127.255.255.255");
        $res = $this->darkSky->getOldCast();
        $exp = "The given location (or time) is invalid.";

        $this->assertEquals($exp, $res["error"]);

    }

    public function testIconTranslator()
    {
        $res = $this->darkSky->translateIcon("clear-night");
        $exp = "moon";

        $this->assertEquals($exp, $res);

        $res = $this->darkSky->translateIcon("rain");
        $exp = "cloud-rain";

        $this->assertEquals($exp, $res);

        $res = $this->darkSky->translateIcon("clear-day");
        $exp = "sun";

        $this->assertEquals($exp, $res);

        $res = $this->darkSky->translateIcon("snow");
        $exp = "snowflake";

        $this->assertEquals($exp, $res);

        $res = $this->darkSky->translateIcon("sleet");
        $exp = "cloud-sleet";

        $this->assertEquals($exp, $res);

        $res = $this->darkSky->translateIcon("cloudy");
        $exp = "cloud";

        $this->assertEquals($exp, $res);

        $res = $this->darkSky->translateIcon("partly-cloudy-day");
        $exp = "cloud-sun";

        $this->assertEquals($exp, $res);

        $res = $this->darkSky->translateIcon("crap");
        $exp = "crap";

        $this->assertEquals($exp, $res);

    }
}
