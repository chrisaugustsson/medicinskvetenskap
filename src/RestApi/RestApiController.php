<?php

namespace Anax\RestApi;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\IpValidator\Validator;
use Anax\IpLocation\Ipstack;
use Anax\IpLocation\Location;
use Anax\Curl\Curl;
use Anax\Weather\DarkSky;


/**
 * Style chooser controller loads available stylesheets from a directory and
 * lets the user choose the stylesheet to use.
 */
class RestApiController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;


    public function indexActionGet()
    {
        $page = $this->di->get("page");
        $page->add("anax/api/index");

        return $page->render([
            "title" => "API Documentation"
        ]);
    }
    /**
     * Validates the IP-address and displays the result.
     *
     * @return object in json format
     */
    public function ipActionPost() : array
    {
        $validator = new Validator();

        $title = "Your IP-address";
        $request = $this->di->get("request");
        $page = $this->di->get("page");

        $ip = $request->getPost("ipAddress");
        $valid = $validator->validate($ip);


        $json = [
            "message" => $valid[1],
            "ip" => $valid[0]
        ];
        return [$json];
    }


    /**
     * Returns the location of a IP-address if valid.
     *
     * @return object in json format
     */
    public function ipLocationActionGet($ip) : array
    {
        $ipIsValid = Validator::isValid($ip);

        if (!$ipIsValid) {
            $json = [
                "ip" => $ip,
                "type" => "Not valid",
            ];
            return [$json];
        }

        $curl = $this->di->get("curl");
        $cfg = $this->di->get("configuration");

        $locationProvider = New Ipstack($curl, $cfg);
        $location = New Location($locationProvider, $ip);
        $res = $location->getLocation();

        $json = [
            "ip" => $res["ip"],
            "type" => $res["type"],
            "city" => $res["city"],
            "country" => $res["country"],
        ];
        return [$json];
    }


    /**
     * Returns current weather forecast for a location
     *
     * @return object in json format
     */
    public function currentForecastActionGet($ip) : array
    {
        $di = $this->di;
        $ipIsValid = Validator::isValid($ip);

        if (!$ipIsValid) {
            $json = [
                "ip" => $ip,
                "type" => "Not valid",
            ];
            return [$json];
        }

        $curl = $di->get("curl");
        $cfg = $di->get("configuration");

        $locationProvider = new IpStack($curl, $cfg);
        $darkSky = new DarkSky($locationProvider, $curl, $cfg);
        $darkSky->setLocation($ip);

        $res = $darkSky->getForecast();

        return [$res];
    }


    /**
     * Returns 30 days historic weather forecast for a location
     *
     * @return object in json format
     */
    public function historyForecastActionGet($ip) : array
    {
        $di = $this->di;
        $ipIsValid = Validator::isValid($ip);

        if (!$ipIsValid) {
            $json = [
                "ip" => $ip,
                "type" => "Not valid",
            ];
            return [$json];
        }

        $curl = $di->get("curl");
        $cfg = $di->get("configuration");

        $locationProvider = new IpStack($curl, $cfg);
        $darkSky = new DarkSky($locationProvider, $curl, $cfg);
        $darkSky->setLocation($ip);

        $res = $darkSky->getOldCast();

        return [$res];
    }
}
