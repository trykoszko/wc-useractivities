<?php

namespace Trykoszko\DataProvider;

/**
 * A class that provides data from API and Database
 */
class Main
{
    protected $api;

    public function __construct(\Trykoszko\Api\Main $api)
    {
        $this->api = $api;
    }

    /**
     * Get all User Activity types
     */
    public function getAllTypes()
    {
        // hardcoded categories but could be from options/post terms/custom fields
        return ["education", "recreational", "social", "diy", "charity", "cooking", "relaxation", "music", "busywork"];
    }

    /**
     * Get Activity of given user
     */
    public function getUserActivity($userId, $force = false)
    {
        $key = USERACTIVITIES_USER_ACTIVITIES_TRANSIENT_KEY . '_' . $userId;

        // if transient exists
        if (!$force && get_transient($key)) {
            return get_transient($key);
        }

        // if transient doesn't exist, create one
        $types = get_user_meta($userId, USERACTIVITIES_USER_ACTIVITIES_TRANSIENT_KEY, true);
        $activity = $this->api->getActivity([
            'types' => $types
        ]);

        set_transient($key, $activity, (24 * 60 * 60 * 60)); // 24h / 1 day

        return $activity;
    }

    /**
     * Get Types that User have chosen in My Account panel
     */
    public function getUserTypes($userId)
    {
        return (array) get_user_meta($userId, USERACTIVITIES_USER_ACTIVITIES_TRANSIENT_KEY, true);
    }
}
