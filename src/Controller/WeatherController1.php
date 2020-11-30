<?php

namespace Anax\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\OpenWeather\NameToGeo;

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
class WeatherController1 implements ContainerInjectableInterface
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
            if (!(filter_var($ipAdd, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) and
            !(filter_var($ipAdd, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4))) {
                $geolocaion = new NameToGeo();
                $ipjson = $geolocaion -> getGeo($ipAdd);
                $lat = $ipjson[0] ->lat;
                $lon = $ipjson[0] ->lon;
            } else {
                $ipgeoweather = $this->di->get("ipgeoweather");
                $ipjson = $ipgeoweather->getJson($ipAdd);
                $lat = $ipjson["latitude"];
                $lon = $ipjson["longitude"];
            }

            var_dump($ipjson);
            // Generate unixtime for 5 days history
            $fiveDays = [];
            for ($i=1; $i < 6; $i++) {
                $fiveDays[$i] = strtotime("-$i day");
            }
            // Get data from openweather 5 days history and 7 days forecast
            $openweather = $this->di->get("openweather");
            $weather = $openweather->getCurl($lat, $lon);
            $history = $openweather->getHistoryMCurl($lat, $lon, $fiveDays);

            $data = [
                "content" => json_encode($ipjson, JSON_PRETTY_PRINT),
                "weather" => $weather,
                "history" => $history,
            ];

            $page->add("weather", $data);
            return $page->render([
                "title" => "Weather",
            ]);
        } else {
            $page->add("weather");
            return $page->render([
                "title" => "Weather",
            ]);
        }
    }
}
