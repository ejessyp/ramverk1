<?php

namespace Anax\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Testclass.
 */
class IpGeoApiControllerTest extends TestCase
{
    // Create the di container.
    protected $di;


    /**
     * Prepare before each test.
     */
    protected function setUp()
    {
        global $di;

        // Setup di
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // Use a different cache dir for unit test
        $di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        $this->di = $di;
    }



    /**
     * Test the route "index".
     */
    public function testIndexActionGet()
    {
        // Setup the controller
        $controller = new IpGeoApiController();
        $controller->setDI($this->di);

        // Test the controller action
        $res = $controller->indexActionGet();
        $res = json_encode($res);
        $this->assertStringContainsString("geoapi", $res);
    }

    public function testIndexActionPost()
    {
        // Setup the controller
        $controller = new IpGeoApiController();
        $controller->setDI($this->di);
        $request     = $this->di->get("request");

        // Test the controller action
        $res = $controller->IndexActionPost();

        $this->assertStringContainsString("openstreet", $res);
    }
}
