<?php

require_once dirname(dirname(dirname(__FILE__))) . '/bootstrap.php';

class ApiTest extends \Codeception\TestCase\WPTestCase
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
    public function testGetActivity() : void
    {
        $activity = $this->plugin->api->getActivity();
        $this->assertNotNull($activity);
    }
}
