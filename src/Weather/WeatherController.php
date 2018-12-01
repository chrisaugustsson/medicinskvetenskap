<?php

namespace Anax\Weather;
use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Curl\Curl;
use Anax\IpLocation\Ipstack;

class WeatherController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function indexActionGet()
    {
        $title = "Forecast from IP";

        $request = $this->di->get("request");
        $page = $this->di->get("page");

        $validIp = $request->getGet("ip") ?? "true";

        // Get users IP-address from SERVER
        $ip = $request->getServer("HTTP_X_FORWARDED_FOR");
        $page->add("anax/weather/index", [
            "ip" => $ip,
            "valid" => $validIp
        ]);

        return $page->render([
            "title" => $title,
        ]);
    }

    public function ipActionGet()
    {
        $di = $this->di;
        $request = $di->get("request");
        $response = $di->get("response");
        $page = $di->get("page");
        $weather = $di->get("weather");
        $location = $di->get("location");

        $ip = $request->getGet("ip");
        $history = $request->getGet("history") ?? null;

        if ($history) {
            return $response->redirect("weather/history?ip=" . $ip);
        }

        $weather->setLocation($ip);

        $res = $weather->getForecast();

        if (isset($res["error"])) {
            return $response->redirect("weather?ip=false");
        }

        $data = [
            "res" => $res
        ];

        $page->add("anax/weather/weather", $data);

        return $page->render([
            "title" => "Local weather"
        ]);
    }

    public function historyActionGet()
    {
        $di = $this->di;
        $request = $di->get("request");
        $response = $di->get("response");
        $page = $di->get("page");
        $ip = $request->getGet("ip");

        $curl = $di->get("curl");
        $cfg = $di->get("configuration");

        $locationProvider = new IpStack($curl, $cfg);
        $darkSky = new DarkSky($locationProvider, $curl, $cfg);
        $darkSky->setLocation($ip);

        $res = $darkSky->getOldCast();

        if (isset($res["error"])) {
            return $response->redirect("weather?ip=false");
        }

        $data = [
            "res" => $res
        ];

        $page->add("anax/weather/history", $data);

        return $page->render([
            "title" => "Local weather"
        ]);
    }
}