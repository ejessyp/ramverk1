<h1>IP validator</h1>
<p>The rest API will accept a JSON parameter in the body that containes the ip.<code> "ip": "194.47.150.9".</code>
</p>
It will return something like this:
<pre>
{
    "ip": "194.47.150.9",
    "hostname": "dbwebb.se",
    "type": "IPv4",
    "valid": "True"
}
</pre>
</p>
<h1>Test IP in API:</h1>
<a href="ip?ip=194.47.150.9">194.47.150.9</a>
<a href="ip?ip=2a00:1450:400f:80b::2003">2a00:1450:400f:80b::2003</a>
<a href="ip?ip=11234567.33">11234567.33</a>

<h1>Test any IP:</h1>
Please input an IP address to test:
<form action="ip/api" method="post">
    <fieldset>
    <legend>IP Address Test</legend>
    <p>
        <input type="text" name="ip" placeholder="127.0.0.1">
        <input type="submit" name=submit value=Validate>
    </p>
    </fieldset>
</form>
