<?php

namespace Anax\Ip;

/**
 * A model class retrievieng data from an external server.
 *
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class Ip
{
    public function getIp(string $ipAdd) : array
    {
        // $acessKey = "ef15cf2a657ad0f81a990794b904b26f";
        // $url = "http://api.ipstack.com/$ipAdd?access_key=$acessKey&hostname=1";
        // $res = file_get_contents($url);
        $hostname = null;
        $type = null;
        if (filter_var($ipAdd, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $type = "IPv6";
            $hostname = $ipAdd;
        } elseif (filter_var($ipAdd, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $type = "IPv4";
            $hostname = gethostbyaddr($ipAdd);
        }

        if (filter_var($ipAdd, FILTER_VALIDATE_IP)) {
            $valid = "True";
        } else {
            $valid = "False";
        }
        $ipArr = array("ip"=> $ipAdd,"hostname"=>$hostname,"type"=>$type,"valid"=>$valid);
        //  var_dump($res);
        // $ipinfo = json_decode($res, true);
        // var_dump($ipinfo);
        // $ipinfo_need = array_slice($ipinfo, 0, 3);
        return $ipArr;
    }
}
