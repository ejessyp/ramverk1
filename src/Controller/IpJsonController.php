<?php

namespace Anax\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample JSON controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 */
class IpJsonController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;


    /**
     * This is the index method action, it handles:
     * GET METHOD mountpoint
     * GET METHOD mountpoint/
     * GET METHOD mountpoint/index
     *
     * @return array
     */
    public function indexActionGet() : array
    {
        $json = [
            "message" => "Use POST with IP-address in body to validate",
            "example" => "POST /ip-json/ {'ip': '8.8.8.8'}",
        ];
        $page = $this->di->get("page");

        $page->add("anax/v2/plain/pre", [
            "content" => $json,
        ]);
        return [$json];
    }

    public function indexActionPost() : array
    {
        $data = $this->di->request->getBody();
        // To change %3A to ":" because of http_build_query
        $data = urldecode($data);
        //$data = $this->di->request->getBodyAsJson();
        //var_dump($data);
        $ipAdd = substr($data, 3);
        // var_dump($ipAdd);
        $hostname = null;
        $type = null;
        if (filter_var($ipAdd, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $type = "IPv6";
            $hostname = $ipAdd;
        } elseif (filter_var($ipAdd, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $type = "IPv4";
            $hostname = gethostbyaddr($ipAdd);
        }
        // var_dump($hostname);
        // var_dump($type);
        if (filter_var($ipAdd, FILTER_VALIDATE_IP)) {
            $valid = "True";
        } else {
            $valid = "False";
        }

        $ipArr = [
           "ip" => $ipAdd,
           "hostname"=>$hostname,
           "type"=>$type,
           "valid"=>$valid,
       ];

        //var_dump($ipArr);
        return [$ipArr];
    }
}
