<?php

namespace Anax\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\IpGeo\IpGeo;
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
class IpGeoApiController implements ContainerInjectableInterface
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
            "example" => "POST /geoapi/ {'ip': '8.8.8.8'}",
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
        // var_dump($data);
        $ipAdd = substr($data, 3);
        // var_dump($ipAdd);
        include dirname(dirname(dirname(__FILE__))). '/config/api/ipstack.php';
        $ip = new IpGeo($ipstack);

        $ipjson = $ip -> getJson($ipAdd);
        // $ipjson = json_encode($ipjson, JSON_PRETTY_PRINT);
        // var_dump($ipjson);
        return [$ipjson];
    }
}
