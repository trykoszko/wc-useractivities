<?php
/**
 * @wordpress-plugin
 * Plugin Name:       WooCommerce User Activity Ideas
 * Plugin URI:        https://github.com/trykoszko/
 * Description:
 * Version:           1.0.0
 * Author:            Michal Trykoszko
 * Author URI:        https://github.com/trykoszko
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       useractivities
 * Domain Path:       /languages
 */

namespace Trykoszko;

use Trykoszko\Plugin\Helper as Helper;

if (!defined('WPINC')) {
    die;
}

require_once plugin_dir_path(__FILE__) . 'bootstrap.php';

function activatePlugin()
{
    Helper::activate();
}

function deactivatePlugin()
{
    Helper::deactivate();
}

register_activation_hook(__FILE__, 'Trykoszko\\activatePlugin');
register_deactivation_hook(__FILE__, 'Trykoszko\\deactivatePlugin');

runPlugin();
