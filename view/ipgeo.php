<?php
$opts = array('http'=>array('header'=>"User-Agent: QingPanCleverAddressScript 3.7.6\r\n"));
$context = stream_context_create($opts);

// Open the file using the HTTP headers set above
$file = file_get_contents('http://nominatim.openstreetmap.org/search/Piazza%20Duomo%20Trento?format=json&addressdetails=1&limit=1&polygon_svg=1', false, $context);

$jsonout = json_decode($file);
// var_dump($jsonout[0]);

?>
<h1>IP Geotagga</h1>
<p>The rest API will accept a JSON parameter in the body that containes the ip.<code> "ip": "194.47.150.9".</code>
</p>
It will return something like this:
<pre>
    {
        "ip": "194.47.150.9",
        "hostname": "dbwebb.tekproj.bth.se",
        "type": "ipv4",
        "continent_code": "EU",
        "continent_name": "Europe",
        "country_code": "SE",
        "country_name": "Sweden",
        "region_code": "K",
        "region_name": "Blekinge",
        "city": "Karlskrona",
        "zip": "371 00",
        "latitude": 56.16122055053711,
        "longitude": 15.586899757385254,
        "location": {
            "geoname_id": 2701713,
            "capital": "Stockholm",
            "languages": [
                {
                    "code": "sv",
                    "name": "Swedish",
                    "native": "Svenska"
                }
            ],
            "country_flag": "http:\/\/assets.ipstack.com\/flags\/se.svg",
            "country_flag_emoji": "\ud83c\uddf8\ud83c\uddea",
            "country_flag_emoji_unicode": "U+1F1F8 U+1F1EA",
            "calling_code": "46",
            "is_eu": true
        }
    }
</pre>
</p>
<h1>Test IP in API:</h1>
<a href="ipgeo?ip=194.47.150.9">194.47.150.9</a>
<a href="ipgeo?ip=2a00:1450:400f:80b::2003">2a00:1450:400f:80b::2003</a>
<a href="ipgeo?ip=11234567.33">11234567.33</a>

<h1>Test any IP:</h1>
Please input an IP address to test:
<form action="ipgeo/api" method="post">
    <fieldset>
    <legend>IP Address Test</legend>
    <p>
        <input type="text" name="ip" placeholder="127.0.0.1">
        <input type="submit" name=submit value=Validate>
    </p>
    </fieldset>
</form>
