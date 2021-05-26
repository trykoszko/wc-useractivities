<?php

namespace Trykoszko\WooCommerce;

/**
 * A class for all WooCommerce extensions
 */
class Main
{
    protected $twig;

    public function __construct(
        \Trykoszko\Twig\Main $twig,
        \Trykoszko\DataProvider\Main $dataProvider
    )
    {
        if (!defined('USERACTIVITIES_USER_ACTIVITIES')) {
            define('USERACTIVITIES_USER_ACTIVITIES', 'user-activities');
        }
        if (!defined('USERACTIVITIES_USER_ACTIVITIES_NICE')) {
            define('USERACTIVITIES_USER_ACTIVITIES_NICE', __('Activities', TEXTDOMAIN));
        }
        if (!defined('USERACTIVITIES_USER_ACTIVITIES_TRANSIENT_KEY')) {
            define('USERACTIVITIES_USER_ACTIVITIES_TRANSIENT_KEY', 'useractivities_user_activities');
        }
        if (!defined('USERACTIVITIES_ACCOUNT_ACTIVITIES_NONCE')) {
            define('USERACTIVITIES_ACCOUNT_ACTIVITIES_NONCE', 'wc_myaccount_activities');
        }

        $this->twig = $twig;
        $this->dataProvider = $dataProvider;
        $this->initHooks();
    }

    protected function initHooks()
    {
        // 'Activities' Woo My Account tab and subpage
        add_filter('woocommerce_account_menu_items', [$this, 'addActivitiesMyAccountPageLink'], 40);
        add_action('init', [$this, 'addActivitiesMyAccountEndpoint']);
        add_action('woocommerce_account_' . USERACTIVITIES_USER_ACTIVITIES . '_endpoint', [$this, 'addActivitiesMyAccountPage']);
    }

    /**
     * Adds a "Activities" link to WC "My Account" sidebar
     */
    public function addActivitiesMyAccountPageLink($menuLinks)
    {
        $menuLinks = array_merge(
            array_slice( $menuLinks, 0, 5, true ),
            [USERACTIVITIES_USER_ACTIVITIES => USERACTIVITIES_USER_ACTIVITIES_NICE],
            array_slice( $menuLinks, 5, null, true )
        );
        return $menuLinks;
    }

    /**
     * Format nice link and rewrite for "My Account" "Activities" subpage
     */
    public function addActivitiesMyAccountEndpoint()
    {
        add_rewrite_endpoint(USERACTIVITIES_USER_ACTIVITIES, EP_PAGES);
    }

    /**
     * Renders "My Account" "Activities" subpage html
     */
    public function addActivitiesMyAccountPage()
    {
        if (is_user_logged_in()) {
            $userId = get_current_user_id();
            $this->twig->render('wc_myaccount_activities', [
                'accountActivityTypesNonce' => USERACTIVITIES_ACCOUNT_ACTIVITIES_NONCE,
                'allTypes' => $this->dataProvider->getAllTypes(),
                'userSelectedTypes' => $this->dataProvider->getUserTypes($userId),
                'activity' => $this->dataProvider->getUserActivity($userId)
            ]);
        } else {
            $this->twig->render('wc_myaccount_notloggedin', []);
        }
    }
}
