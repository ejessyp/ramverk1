<?php

namespace Anax\IpGeo;


/**
 * A model class retrievieng data from an external server.
 *
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class IpGeo1
{
    // load apikey file when do an instance of IpGeo1 class
    protected $apikey;
    public function __construct($ipstack)
    {
        $this->apikey = $ipstack;
    }


    public function getJson(string $ipAdd) : array
    {
        $url = "http://api.ipstack.com/$ipAdd?access_key=$this->apikey&hostname=1";
        $res = file_get_contents($url);

        // var_dump($res);
        $ipinfo = json_decode($res, true);
        $lat = $ipinfo["latitude"];
        $lng =  $ipinfo["longitude"];
        $ipinfo['link'] = "https://www.openstreetmap.org/?mlat=$lat&mlon=$lng#map=15/$lat/$lng";

        return $ipinfo;
    }
}
