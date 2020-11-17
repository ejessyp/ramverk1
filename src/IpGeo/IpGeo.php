<?php

namespace Anax\IpGeo;


/**
 * A model class retrievieng data from an external server.
 *
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class IpGeo
{
    public function getJson(string $ipAdd) : array
    {
        include('../config/api/ipstack.php');
        // var_dump($ipstack);
        $acessKey = $ipstack;
        $url = "http://api.ipstack.com/$ipAdd?access_key=$acessKey&hostname=1";
        $res = file_get_contents($url);

        // var_dump($res);
        $ipinfo = json_decode($res, true);
        $lat = $ipinfo["latitude"];
        $lng =  $ipinfo["longitude"];
        $ipinfo['link'] = "https://www.openstreetmap.org/?mlat=$lat&mlon=$lng#map=15/$lat/$lng";

        return $ipinfo;
    }
}
