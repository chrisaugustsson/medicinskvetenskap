<?php

namespace Anax\Weather;
use Anax\Interfaces\LocationProviderInterface;

class DarkSky
{
    private $locationProvider;
    private $lat;
    private $long;
    private $apiKey;

    public function __construct(LocationProviderInterface $locationProvider, $curl, $cfg)
    {
        $this->locationProvider = $locationProvider;
        $this->curl = $curl;
        $keys = $cfg->load("api_keys.php");
        $this->apiKey = $keys["config"]["darksky"];
    }

    public function setLocation($ip)
    {
        $locationProvider = $this->locationProvider;

        $locationProvider->setLocation($ip);
        $this->lat = $locationProvider->getLat();
        $this->long = $locationProvider->getLong();
        $this->city = $locationProvider->getCity();
        $this->country = $locationProvider->getCountry();

    }

    public function getForecast()
    {
        $url = "https://api.darksky.net/forecast/" . $this->apiKey . "/" . $this->lat . "," . $this->long . "?units=si";
        $res = $this->curl->get($url);

        if (isset($res->code) && $res->code === 400) {
            return ["error" => $res->error];
        }

        $data = [
            "lat" => $this->lat,
            "long" => $this->long,
            "city" => $this->city,
            "country" => $this->country,
            "currentTemp" => $res->currently->temperature,
            "currentIcon" => $this->translateIcon($res->currently->icon),
            "currentSum" => $res->currently->summary,
            "dailyTempHigh" => [
                $res->daily->data[0]->temperatureHigh,
                $res->daily->data[1]->temperatureHigh,
                $res->daily->data[2]->temperatureHigh,
                $res->daily->data[3]->temperatureHigh
            ],
            "dailyTempLow" => [
                $res->daily->data[0]->temperatureLow,
                $res->daily->data[1]->temperatureLow,
                $res->daily->data[2]->temperatureLow,
                $res->daily->data[3]->temperatureLow
            ],
            "dailyIcon" => [
                $this->translateIcon($res->daily->data[0]->icon),
                $this->translateIcon($res->daily->data[1]->icon),
                $this->translateIcon($res->daily->data[2]->icon),
                $this->translateIcon($res->daily->data[3]->icon)
            ]
        ];

        return $data;
    }

    public function getOldCast()
    {
        $baseUrl = "https://api.darksky.net/forecast/";
        $today = date("Y-m-d H:i:s");
        $urls = [];
        $data = [];


        for ($i=1; $i < 31; $i++) {
            $old = date_create($today)->modify(-$i . ' days')->format('Y-m-d');
            $fetchURL = $baseUrl . $this->apiKey . "/" . $this->lat . "," . $this->long . "," . $old . "T12:00:00" . "?units=si";
            array_push($urls, $fetchURL);
        }

        $res = $this->curl->getMulti($urls);

        if (isset($res[0]->code) && $res[0]->code === 400) {
            return ["error" => $res[0]->error];
        }

        foreach ($res as $i => $forecast) {
            $data["history"][$i] = [
                "date" => date("D, d M", $res[$i]->currently->time),
                "currentTemp" => $res[$i]->currently->temperature,
                "currentIcon" => $this->translateIcon($res[$i]->currently->icon),
                "currentSum" => $res[$i]->currently->summary,
            ];

        }

        $data["city"] = $this->city;
        $data["lat"] = $this->lat;
        $data["long"] = $this->long;
        $data["country"] = $this->country;

        return $data;
    }

    public function translateIcon($icon)
    {
        switch ($icon) {
            case 'clear-night':
                return "moon";
                break;
            case 'rain':
                return "cloud-rain";
                break;
            case 'clear-day':
                return "sun";
                break;
            case 'snow':
                return "snowflake";
                break;
            case 'sleet':
                return "cloud-sleet";
                break;
            case 'cloudy':
                return "cloud";
                break;
            case 'partly-cloudy-day':
                return "cloud-sun";
                break;
            default:
                return $icon;
                break;
        }
    }
}