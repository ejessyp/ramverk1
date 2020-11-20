<?php
// $opts = array('http'=>array('header'=>"User-Agent: QingPanCleverAddressScript 3.7.6\r\n"));
// $context = stream_context_create($opts);
//
// // Open the file using the HTTP headers set above
// $file = file_get_contents('http://nominatim.openstreetmap.org/search/Piazza%20Duomo%20Trento?format=json&addressdetails=1&limit=1&polygon_svg=1', false, $context);
//
// $jsonout = json_decode($file);
// var_dump($jsonout[0]);
if (isset($content)) {
    $content_array = json_decode($content, true);
    // var_dump($content_array);
    $lat = $content_array['latitude'];
    $lng = $content_array['longitude'];
}

?>
<h1>Locate IP:</h1>
Please input an IP address to test:
<form action="ipgeo" method="get">
    <fieldset>
    <legend>IP Address Test</legend>
    <p>
        <input type="text" name="ip" value="194.47.150.9">
        <input type="submit" name=submit value=Validate>
    </p>
    </fieldset>
</form>
<?php
if (isset($content)) {

    echo " <div class=resetBtn>
        <a href='ipgeo'>Reset Search</a>
        </div>
        <div class=validResult>
            <p><b>IP:</b> {$content_array['ip']} </p>
            <p><b>Type:</b> {$content_array['type']}</p>
            <p><b>Host:</b> {$content_array['hostname']}</p>
            <p><b>Continent:</b> {$content_array['continent_name']}</p>
            <p><b>Country:</b> {$content_array['country_name']}</p>
            <p><b>Region:</b> {$content_array['region_name']}</p>
            <p><b>City:</b> {$content_array['city']}</p>
            <p><b>Latitude:</b> {$content_array['latitude']}</p>
            <p><b>Longitude:</b> {$content_array['longitude']}</p>
            <img class=countryFlag src={$content_array['location']['country_flag']}>
        </div>";
};


?>
<div id="osm-map"></div>
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
<link href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" rel="stylesheet"/>
<?php
if (isset($content)) {
    echo "<script type=text/javascript>
    var lat = $lat;
    var lng = $lng;";
    include("map.js");
    echo "</script>";
};
?>
<h1>IpGeo Json API</h1>
The following routers:
<pre>
<code>
GET /geoapi show how to use API.
POST /geoapi Validate ip-address by sending ip address in the body
Such as: {"ip": "194.47.150.9"}
</code>
</pre>

<h1>Testroutes:</h1>
<div class="testRoutes">
    <form class="hiddenForm" method="post" action="geoapi">
        <input type="hidden" name="ip" value="194.47.150.9"/>
        <input class="valid" type="submit" name="" value="Validerar"/>
    </form>
        <form class="hiddenForm" method="post" action="geoapi">
            <input type="hidden" name="ip" value="2a00:1450:400f:80b::2003"/>
            <input class="valid" type="submit" name="" value="Validerar"/>
        </form>
        <form class="hiddenForm" method="post" action="geoapi/">
            <input type="hidden" name="ip" value="8.8.8.8.8"/>
            <input class="notValid" type="submit" name="" value="Validerar inte"/>
        </form>
</div>

<h1>Test IP with Json-api:</h1>
Please input an IP address to test:
<form action="geoapi" method="post">
    <fieldset>
    <legend>IP Address Test</legend>
    <p>
        <input type="text" name="ip" value="194.47.150.9">
        <input type="submit" name=submit value=Validate>
    </p>
    </fieldset>
</form>
