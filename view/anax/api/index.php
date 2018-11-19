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

</div>