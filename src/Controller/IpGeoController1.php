<?php

namespace Anax\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\IpGeo\IpGeo1;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class IpGeoController1 implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function indexAction() : object
    {
        $page = $this->di->get("page");
        $request     = $this->di->get("request");
        $queryString = http_build_query($request->getGet(), '', ', ');
        $ipAdd = substr($queryString, 3);
        // if it is ipv6, change replace the %3A to ":"
        if (strpos($ipAdd, "%3A") > 0) {
            $ipAdd = str_replace("%3A", ":", $ipAdd);
        }
        // var_dump($ipAdd);
        if ($queryString) {

            // load the config file with apikey
            include('../config/api/ipstack.php');
            $ip = new IpGeo1($ipstack);
            $ipjson = $ip -> getJson($ipAdd);
            $data = [
                "content" => json_encode($ipjson, JSON_PRETTY_PRINT),
            ];

            $page->add("ipgeo_map", $data);
            return $page->render([
                "title" => "Ip in Json format",
            ]);
        } else {
            $page->add("ipgeo");
            return $page->render([
                "title" => "Ip Geotagga",
            ]);
        }
    }

    public function apiActionPost() : object
    {
        $page = $this->di->get("page");
        $request     = $this->di->get("request");

        $submit = $request->getPost("submit");
        $ipAdd = $request->getPost("ip");

        if ($submit) {
            // The below line  will bring problem(can not open stream) when testing
            // include '../config/api/ipstack.php';
            include dirname(dirname(dirname(__FILE__))). '/config/api/ipstack.php';
            $ip = new IpGeo1($ipstack);
            $ipjson = $ip -> getJson($ipAdd);
            $data = [
                "content" => json_encode($ipjson, JSON_PRETTY_PRINT),
            ];
            $page->add("ipgeo_map", $data);
            // $page->add("anax/v2/plain/pre", $data);
            return $page->render([
                "title" => "Ip Geotagga in Json format",
            ]);
        }
    }
}
