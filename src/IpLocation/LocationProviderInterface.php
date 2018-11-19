<?php

namespace Anax\IpLocation;

interface LocationProviderInterface
{
    public function setLocation(string $ip);

    public function getCity();

    public function getType();

    public function getCountry();

    public function getIp();
}