<?php

namespace Anax\IpLocation;
use Anax\Curl\Curl;
use Anax\Interfaces\LocationProviderInterface;


class Ipstack implements LocationProviderInterface
{
    private $apiKey;
    private $ip;
    private $type;
    private $city;
    private $country;
    private $long;
    private $lat;
    private $curl;

    public function __construct($curl, $cfg)
    {
        $this->curl = $curl;
        $keys = $cfg->load("api_keys.php");
        $this->apiKey = $keys["config"]["ipstack"];
    }


    public function setLocation(string $ip)
    {
        $curl = $this->curl;
        $withOutSpecial = str_replace(":", ".", $ip);
        $url = "http://api.ipstack.com/" . $ip . "?access_key=" . $this->apiKey;
        $res;

        $res = $curl->get($url);

        $this->ip = $res->ip;
        $this->type = $res->type;
        $this->city = $res->city;
        $this->country = $res->country_name;
        $this->lat = $res->latitude;
        $this->long = $res->longitude;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function getLat()
    {
        return $this->lat;
    }

    public function getLong()
    {
        return $this->long;
    }
}
