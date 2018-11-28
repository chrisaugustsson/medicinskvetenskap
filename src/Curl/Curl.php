<?php

namespace Anax\Curl;

class Curl
{
    private $cache;

    public function __construct($cache)
    {
        $this->cache = $cache;
    }


    public function get(string $url)
    {
        $cache = $this->cache;

        $cleanUrl = preg_replace('/[^A-Za-z0-9\-]/', '', $url);

        if ($cache->get($cleanUrl)) {
            return json_decode($cache->get($cleanUrl));
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $res = curl_exec($ch);
        curl_close($ch);

        $cache->set($cleanUrl, $res);

        return json_decode($res);

    }

    public function getMulti(array $urls)
    {
        $res = [];
        $mh = curl_multi_init();

        foreach ($urls as $key => $value) {
            $multiCurl[$key] = curl_init();
            curl_setopt($multiCurl[$key], CURLOPT_URL,$urls[$key]);
            curl_setopt($multiCurl[$key], CURLOPT_RETURNTRANSFER,1);
            curl_multi_add_handle($mh, $multiCurl[$key]);
        }

        $index = null;
        do {
            curl_multi_exec($mh,$index);
        } while($index > 0);

        foreach($multiCurl as $k => $ch) {
            $res[$k] = json_decode(curl_multi_getcontent($ch));
            curl_multi_remove_handle($mh, $ch);
        }

        curl_multi_close($mh);

        return $res;
    }
}