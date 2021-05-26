<?php

namespace Trykoszko\Plugin;

use Trykoszko\Container\Main as DIContainer;
use Trykoszko\Api\Main as Api;
use Trykoszko\Widgets\UserActivity as UserActivityWidget;

/**
 * Main Plugin class
 */
class Main
{
    protected $wc;
    public $api;
    protected $twig;

    public function __construct(DIContainer $container)
    {
        $container = $container->getInstance();
        $this->wc = $container->get('WC');
        $this->api = $container->get('Api');
        $this->twig = $container->get('Twig');
        $this->dataProvider = $container->get('DataProvider');
    }

    public function run()
    {
        $this->initHooks();
    }

    public function initHooks()
    {
        add_action( 'admin_post_nopriv_wc_myaccount_save_activities', [$this, 'handleUserActivityTypesSubmit'] );
        add_action( 'admin_post_wc_myaccount_save_activities', [$this, 'handleUserActivityTypesSubmit'] );

        add_action( 'init', [$this, 'getCurrentUserActivityIfNoTransient'] );

        add_action( 'widgets_init', function() {
            $widget = new UserActivityWidget(
                $this->twig,
                $this->dataProvider
            );
            register_widget( $widget );
        });
    }

    /**
     * Get Current user activity idea if not fetched.
     * Hooked to init so loads only when user logs in.
     */
    public function getCurrentUserActivityIfNoTransient()
    {
        if (is_user_logged_in()) {
            if (get_the_ID() == get_option('woocommerce_myaccount_page_id')) {
                $userId = get_current_user_id();
                if (!get_transient(USERACTIVITIES_USER_ACTIVITIES_TRANSIENT_KEY . '_' . $userId)) {
                    $this->dataProvider->getUserActivity($userId);
                }
            }
        }
    }

    /**
     * admin_post.php action that fires when user submits its Activity Types in My Account WC panel
     */
    public function handleUserActivityTypesSubmit()
    {
        if (!function_exists('rejectUserTypeSelection')) {
            function rejectUserTypeSelection() {
                wp_die(__('Oops! Something went wrong.', TEXTDOMAIN));

                wp_safe_redirect(get_permalink(get_option('woocommerce_myaccount_page_id')) . USERACTIVITIES_USER_ACTIVITIES);
                exit();
            }
        }

        if (!is_user_logged_in()) rejectUserTypeSelection();

        $nonce = isset($_REQUEST['_wpnonce']) ? $_REQUEST['_wpnonce'] : null;
        if (!$nonce) rejectUserTypeSelection();
        if (!wp_verify_nonce($nonce, USERACTIVITIES_ACCOUNT_ACTIVITIES_NONCE)) rejectUserTypeSelection();

        $activityTypes = isset($_REQUEST['activity_types']) ? $_REQUEST['activity_types'] : null;

        update_user_meta(get_current_user_id(), USERACTIVITIES_USER_ACTIVITIES_TRANSIENT_KEY, $activityTypes);

        error_log($this->dataProvider->getUserActivity(get_current_user_id(), true));

        wp_safe_redirect(get_permalink(get_option('woocommerce_myaccount_page_id')) . USERACTIVITIES_USER_ACTIVITIES);
        exit();
    }
}
