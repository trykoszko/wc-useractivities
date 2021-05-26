<?php

use Trykoszko\Plugin\Main as Plugin;
use Trykoszko\Container\Main as DIContainer;

require_once dirname(__FILE__) . '/vendor/autoload.php';

if (!defined('USERACTIVITIES_ROOT_DIR')) {
    define('USERACTIVITIES_ROOT_DIR', dirname(__FILE__) . '/');
}

if (!defined('TEXTDOMAIN')) {
    define('TEXTDOMAIN', 'useractivities');
}

function runPlugin()
{
    $diContainer = new DIContainer();
    $plugin = new Plugin($diContainer);
    $plugin->run();

    return $plugin;
}
