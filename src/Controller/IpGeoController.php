<?php

namespace Anax\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\IpGeo\IpGeo;

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
class IpGeoController implements ContainerInjectableInterface
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
    public function indexActionGet() : object
    {
        $page = $this->di->get("page");
        $request     = $this->di->get("request");
        // var_dump($request->getGet('ip'));
        $submit = $request->getGet('submit');
        $ipAdd = $request->getGet('ip');

        if ($submit) {
            // load the config file with apikey
            include('../config/api/ipstack.php');
            $ip = new IpGeo($ipstack);
            $ipjson = $ip -> getJson($ipAdd);
            $data = [
                "content" => json_encode($ipjson, JSON_PRETTY_PRINT),
            ];

            $page->add("ipgeo", $data);
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
}
