<?php

namespace Anax\IpLocation;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\IpValidator\Validator;
use Anax\Curl\Curl;

/**
 * Style chooser controller loads available stylesheets from a directory and
 * lets the user choose the stylesheet to use.
 */
class LocationController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;


    /**
     * Display the input field for IP address.
     *
     * @return object
     */
    public function indexActionGet() : object
    {
        $title = "Position from IP";
        $di = $this->di;

        $request = $di->get("request");
        $page = $di->get("page");

        // Get users IP-address from SERVER
        $ip = $request->getServer("HTTP_X_FORWARDED_FOR");
        $page->add("anax/iplocation/index", [
            "ip" => $ip
        ]);

        return $page->render([
            "title" => $title,
        ]);
    }


    public function locateActionGet() : object
    {
        $di = $this->di;

        $page = $di->get("page");
        $request = $di->get("request");
        $ip = $request->getGet("ip");

        $ipIsValid = Validator::isValid($ip);

        if (!$ipIsValid) {
            $page->add("anax/iplocation/invalid");

            return $page->render([
                "title" => "testing"
            ]);
        }

        $locationProvider = $di->get("location");
        $location = New Location($locationProvider, $ip);
        $res = $location->getLocation();

        $data = [
            "location" => $res
        ];


        $page->add("anax/iplocation/location", $data);

        return $page->render([
            "title" => "Location of IP-address"
        ]);
    }
}
