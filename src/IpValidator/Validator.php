<?php
namespace Anax\IpValidator;

class Validator
{
    public function validate($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            return [$ip, "This is a valid IPv6 address!"];
        } elseif (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return [$ip, "This is a valid IPv4 address!"];
        } else {
            return [$ip, "No valid IP address entered"];
        }
    }
}
