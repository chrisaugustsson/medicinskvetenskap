<?php

namespace Anax\View;

/**
 * API Documentation
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());



?>

<div class="section">
    <div class="content">
        <h1>API Docs</h1>
        <h3>Validate IP-address</h3>
        <p>Validate a IP-address using:</p>
        <pre>POST /api/ip</pre>
        <p>Required parameters:</p>
        <pre>ipAddress</pre>
        <p>Response:</p>

        <pre>
{
    "message": "This is a valid IPv6 address!",
    "ip": "2001:db8:85a3:0:0:8a2e:370:7334"
}
        </pre>


        <form action="api/ip" method="post">
            <input type="hidden" name="ipAddress" value="2001:db8:85a3:0:0:8a2e:370:7334">
            <button class="button">Test it here!</button>
        </form>
    </div>
    <hr>
    <div class="content">
        <h3>Location from IP-address</h3>
        <p>Get location using ip-address from:</p>
        <pre>GET /api/ip-location/[ip-address]</pre>
        <p>Response:</p>
        <pre>
{
    "ip": "92.232.60.151",
    "type": "ipv4",
    "city": "Liverpool",
    "country": "United Kingdom"
}
        </pre>
        <a href="api/ip-location/92.232.60.151"><button class="button">Test it here!</button></a>
    </div>
    <hr>
    <div class="content">
        <h3>Current weather info based on location from IP-address</h3>
        <p>Collect data using this endpoint:</p>
        <pre>GET /api/current-forecast/[ip-address]</pre>
        <p>Response:</p>
        <pre>
{
    "lat": 57.4833,
    "long": 12.6333,
    "city": "Skene",
    "country": "Sweden",
    "currentTemp": -1.19,
    "currentIcon": "moon",
    "currentSum": "Clear",
    "dailyTempHigh": [
        -0.18,
        -0.92,
        -0.79,
        1.03
    ],
    "dailyTempLow": [
        -5.88,
        -5.73,
        -6.09,
        1.14
    ],
    "dailyIcon": [
        "sun",
        "sun",
        "sun",
        "partly-cloudy-night"
    ]
}
        </pre>
        <a href="api/current-forecast/91.232.60.139"><button class="button">Test it here!</button></a>
    </div>
    <hr>
        <div class="content">
        <h3>Historic weather info based on location from IP-address</h3>
        <p>Get the past 30days of forecast:</p>
        <pre>GET /api/history-forecast/[ip-address]</pre>
        <p>Response:</p>
        <pre>
{
    "history": [
        {
            "date": "Mon, 26 Nov",
            "currentTemp": -2.16,
            "currentIcon": "cloud-sun",
            "currentSum": "Mostly Cloudy"
        },
        {
            "date": "Sun, 25 Nov",
            "currentTemp": -0.18,
            "currentIcon": "sun",
            "currentSum": "Clear"
        },

    ...

    ],
    "city": "Skene",
    "lat": 57.4833,
    "long": 12.6333,
    "country": "Sweden"
}
        </pre>
        <a href="api/current-forecast/91.232.60.139"><button class="button">Test it here!</button></a>
    </div>

</div>