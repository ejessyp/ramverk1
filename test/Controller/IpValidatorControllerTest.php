<?php

namespace Anax\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Testclass.
 */
class IpValidatorControllerTest extends TestCase
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
    public function testIndexAction()
    {
        // Setup the controller
        $controller = new IpValidatorController();
        $controller->setDI($this->di);
        // $request     = $this->di->get("request");
        // Test the controller action

        $res = $controller->indexAction();
        $this->assertInstanceOf("\Anax\Response\Response", $res);
    }



    /**
     * Test the apiActionPost
     */
    public function testApiActionPost()
    {
        // Setup the controller
        $controller = new IpValidatorController();
        $controller->setDI($this->di);
        $request     = $this->di->get("request");
        $request->setPost('ip', '194.47.150.9');
        $request->setPost('submit', 'submit');
        // Test the controller action
        $res = $controller->apiActionPost();
        $this->assertInstanceOf("\Anax\Response\Response", $res);
        // $this->assertInstanceOf(ResponseUtility::class, $res);
    }
}
