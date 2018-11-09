<?php

namespace Anax\View;

/**
 * Style chooser.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());



?>
<div class="section">
    <div class="content">
    <h1>Validate a IP-address</h1>
        <form action="ip/validate" method="post">
            <div class="field">
                <label class="label">Enter IP-address to validate</label>
                <input type="text" class="input" name="ipAddress">
            </div>
            <button class="button">Validate</button>
        </form>
    </div>
</div>

<div class="section">
    <div class="content">
        <h1>The validate REST-api</h1>
        <p>The validator also excists as a API-service which you can use freely. The API responds to api/ip and only responds to POST requests.</p>
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
</div>
