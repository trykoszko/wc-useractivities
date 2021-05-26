<?php

// note: this is just an example class.. no auth is needed with the selected free API.

namespace Trykoszko\Api;

/**
 * A class that allows external API authentication
 */
class Auth
{
    protected $accessToken;

    public function __construct()
    {
        if (!defined('USERACTIVITIES_ACCESS_TOKEN_OPTION_NAME')) {
            define('USERACTIVITIES_ACCESS_TOKEN_OPTION_NAME', 'useractivities_ext_api_token');
        }

        $this->assignAccessToken();
    }

    /**
     * Assign access token from WordPress options
     */
    public function assignAccessToken()
    {
        // just a demo...
        // $token = get_option(USERACTIVITIES_ACCESS_TOKEN_OPTION_NAME);
        // if (!$token) {
        //     wp_die(__('No API access token', TEXTDOMAIN));
        //     exit();
        // }
        $this->accessToken = 'useractivities_token_asdfghjkl' ?? null;
    }

    public function getAccessToken()
    {
        return (string) $this->accessToken;
    }
}
