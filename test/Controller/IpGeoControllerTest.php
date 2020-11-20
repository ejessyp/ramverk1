<?php

namespace Anax\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Testclass.
 */
class IpGeoControllerTest extends TestCase
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
        $controller = new IpGeoController();
        $controller->setDI($this->di);
        $request     = $this->di->get("request");
        $submit = $request->getGet('submit');
        $ipAdd = $request->getGet('ip');
        // Test the controller action
        $res = $controller->indexActionGet();
        $this->assertInstanceOf("\Anax\Response\Response", $res);
    }

}