<?php

namespace Anax\IpValidator;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * Style chooser controller loads available stylesheets from a directory and
 * lets the user choose the stylesheet to use.
 */
class IpValidatorController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;


    /**
     * Display the input field for IP address.
     *
     * @return object
     */
    public function indexActionGet() : object
    {
        $title = "Validate IP";

        $page = $this->di->get("page");
        $page->add("anax/ipvalidate/index");

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * Validates the IP-address and displays the result.
     *
     * @return object
     */
    public function validateActionPost() : object
    {
        $validator = new Validator();

        $title = "Your IP-address";
        $request = $this->di->get("request");
        $page = $this->di->get("page");

        $ip = $request->getPost("ipAddress");
        $valid = $validator->validate($ip);

        $page->add("anax/ipvalidate/validate", [
            "valid" => $valid
        ]);

        return $page->render([
            "title" => $title
        ]);
    }
}
