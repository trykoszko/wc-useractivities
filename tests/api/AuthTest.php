<?php

require_once dirname(dirname(dirname(__FILE__))) . '/bootstrap.php';

class AuthTest extends \Codeception\TestCase\WPTestCase
{
    protected $plugin;

    public function setUp(): void
    {
        // Before...
        parent::setUp();

        $this->plugin = runPlugin();
    }

    public function tearDown(): void
    {
        // Your tear down methods here.

        // Then...
        parent::tearDown();
    }

    // Tests
    public function testGetAccessToken() : void
    {
        $this->assertNotNull($this->plugin->api->auth->getAccessToken());
    }
}
