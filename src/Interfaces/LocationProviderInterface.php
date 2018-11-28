<?php

namespace Anax\Interfaces;

interface LocationProviderInterface
{
    public function setLocation(string $ip);

    public function getCity();

    public function getType();

    public function getCountry();

    public function getIp();

    public function getLat();

    public function getLong();
}