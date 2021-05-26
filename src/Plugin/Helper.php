<?php

namespace Trykoszko\Plugin;

class Helper {

    /**
     * Runs on plugin activation
     */
    public static function activate()
    {
        if (!is_plugin_active('woocommerce/woocommerce.php') && current_user_can('activate_plugins')) {
            wp_die(
                sprintf(
                    __('This plugin requires <a target="_blank" href="https://wordpress.org/plugins/woocommerce/">WooCommerce</a> in order to work. <br><a href="%s">&laquo; Return to Plugins</a>', TEXTDOMAIN),
                    \admin_url( 'plugins.php' )
                )
            );
        }
    }

    /**
     * Runs on plugin deactivation
     */
    public static function deactivate()
    {}

}
