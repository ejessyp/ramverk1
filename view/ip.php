<h1>IP validator</h1>
<form action="ip/api" method="post">
    <fieldset>
    <legend>IP Address Test</legend>
    <p>
        <input type="text" name="ip"  value="194.47.150.9">
        <input type="submit" name=submit value=Validate>
    </p>
    </fieldset>
</form>
TestRoutes:
<a href="ip?ip=194.47.150.9">194.47.150.9</a>
<a href="ip?ip=2a00:1450:400f:80b::2003">2a00:1450:400f:80b::2003</a>
<a href="ip?ip=11234567.33">11234567.33</a>
<h1>Json API</h1>
The following routers:
<pre>
<code>
GET /ipjson show how to use API.
POST /ipjson Validate ip-address by sending ip address in the body
Such as: {"ip": "194.47.150.9"}
</code>
</pre>
It will return something like this:
<pre>
{
    "ip": "194.47.150.9",
    "hostname": "dbwebb.se",
    "type": "IPv4",
    "valid": "True"
}
</pre>
<h1>Testroutes:</h1>
<div class="testRoutes">
        <form class="hiddenForm" method="post" action="ipjson">
            <input type="hidden" name="ip" value="2a00:1450:400f:80b::2003"/>
            <input class="valid" type="submit" name="" value="Validerar"/>
        </form>
        <form class="hiddenForm" method="post" action="ipjson/">
            <input type="hidden" name="ip" value="8.8.8.8.8"/>
            <input class="notValid" type="submit" name="" value="Validerar inte"/>
        </form>
    </div>

<h1>Test IP with Json-api:</h1>
Please input an IP address to test:
<form action="ipjson" method="post">
    <fieldset>
    <legend>IP Address Test</legend>
    <p>
        <input type="text" name="ip" value="194.47.150.9">
        <input type="submit" name=submit value=Validate>
    </p>
    </fieldset>
</form>
