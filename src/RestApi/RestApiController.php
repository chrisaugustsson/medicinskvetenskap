<?php

namespace Anax\RestApi;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\IpValidator\Validator;

/**
 * Style chooser controller loads available stylesheets from a directory and
 * lets the user choose the stylesheet to use.
 */
class RestApiController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * Validates the IP-address and displays the result.
     *
     * @return object
     */
    public function ipActionPost() : array
    {
        $validator = new Validator();

        $title = "Your IP-address";
        $request = $this->di->get("request");
        $page = $this->di->get("page");

        $ip = $request->getPost("ipAddress");
        $valid = $validator->validate($ip);


        $json = [
            "message" => $valid[1],
            "ip" => $valid[0]
        ];
        return [$json];
    }
}
