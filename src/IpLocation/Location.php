<?php
namespace Anax\IpLocation;
use Anax\Interfaces\LocationProviderInterface;

class Location
{
    private $locationProvider;
    private $ip;


    public function __construct(LocationProviderInterface $locationProvider, $ip)
    {
        $this->locationProvider = $locationProvider;
        $this->ip = $ip;
    }

    public function getLocation()
    {
        $locationProvider = $this->locationProvider;
        $locationProvider->setLocation($this->ip);

        return [
            "ip" => $locationProvider->getIp(),
            "type" => $locationProvider->getType(),
            "city" => $locationProvider->getcity(),
            "country" => $locationProvider->getcountry(),
            "lat" => $locationProvider->getLat(),
            "long" => $locationProvider->getLong()
        ];
    }
}
