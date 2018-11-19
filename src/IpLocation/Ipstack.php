<?php

namespace Anax\IpLocation;


class Ipstack implements LocationProviderInterface
{
    private $apiKey = "76d2dc7dd12afedf6fc8bf90e2a75e26";
    private $ip;
    private $type;
    private $city;
    private $country;
    private $cache;

    public function __construct($cache)
    {
        $this->cache = $cache;
    }


    public function setLocation(string $ip)
    {
        $cache = $this->cache;
        $withOutSpecial = str_replace(":", ".", $ip);
        if ($cache->get($withOutSpecial)) {
            $data =  $cache->get($withOutSpecial);
            $this->ip = $data["ip"];
            $this->type = $data["type"];
            $this->city = $data["city"];
            $this->country = $data["country"];
        } else {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://api.ipstack.com/" . $ip . "?access_key=" . $this->apiKey);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            $res = curl_exec($ch);
            curl_close($ch);

            $decoded = json_decode($res);

            $this->ip = $decoded->ip;
            $this->type = $decoded->type;
            $this->city = $decoded->city;
            $this->country = $decoded->country_name;

            $cache->set($withOutSpecial, [
                "ip" => $decoded->ip,
                "type" => $decoded->type,
                "city" => $decoded->city,
                "country" => $decoded->country_name
            ]);
        }
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
}
