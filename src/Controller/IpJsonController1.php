<?php

namespace Anax\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Ip\Ip;

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
class IpJsonController1 implements ContainerInjectableInterface
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
        if (strpos($ipAdd, "%3A") > 0) {
            $ipAdd = str_replace("%3A", ":", $ipAdd);
        }
        // var_dump($ipAdd);
        if ($queryString) {
            $ip = new Ip;
            $ipjson = $ip -> getIp($ipAdd);
            $data = [
                "content" => json_encode($ipjson, JSON_PRETTY_PRINT),
            ];

            $page->add("anax/v2/plain/pre", $data);
            return $page->render([
                "title" => "Ip in Json format",
            ]);
        } else {
            $page->add("ip");
            return $page->render([
                "title" => "Ip validator",
            ]);
        }
    }

    public function apiActionPost() : object
    {
        $page = $this->di->get("page");
        $request     = $this->di->get("request");
        $url = "{$request->getBaseUrl()}/ipjson/api";
        var_dump($url);
        $submit = $request->getPost("submit");
        $ipAdd = $request->getPost("ip");
        $data = array('ip' => $ipAdd);

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data)
            )
        );
        var_dump($options);
        $context  = stream_context_create($options);

        return file_get_contents($url, false, $context);
        // if ($submit) {
        //     $ip = new Ip;
        //     $ipjson = $ip -> getIp($ipAdd);
        //     $data = [
        //         "content" => json_encode($ipjson, JSON_PRETTY_PRINT),
        //     ];
        //
        //     $page->add("anax/v2/plain/pre", $data);
        //     return $page->render([
        //         "title" => "Ip in Json format",
        //     ]);
        // }
    }

    public function ipActionPost()
    {
        if ($this->di->request->getPost('address')) {
            $page = $this->di->get("page");

            $url = "{$this->di->request->getBaseUrl()}/ipjson";
            // $url = $this->di->get("url")->create("api/ip");
            $data = array('address' => $this->di->request->getPost('address'));
            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data)
                )
            );

            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);

            $result = json_decode($result);

            $page->add('validate/ip/show', [
                "result" => $result
            ]);

            return $page->render([
                "title" => "IP Validator",
            ]);
        }
        return "no address specified.";
    }
}
