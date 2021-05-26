<?php

namespace Trykoszko\Api;

use GuzzleHttp\Exception\RequestException as RequestException;

/**
 * External API fetch class
 */
class Main
{
    private $guzzle;

    public function __construct(
        \GuzzleHttp\Client $guzzleClient,
        \Trykoszko\Api\Auth $auth
    )
    {
        $this->guzzle = $guzzleClient;
        $this->auth = $auth;
    }

    /**
     * Get single activity for given activity types
     */
    public function getActivity(array $params = null)
    {
        // just a type of placeholder
        $queryParams = '';
        if ($params && !empty($params)) {
            $allParams = [];
            foreach ($params as $paramKey => $paramValue) {
                // pick only one, random type (API limitation)
                if ($paramKey === 'types') {
                    $paramValue = is_array($paramValue) ? $paramValue[array_rand($paramValue)] : null;
                    if ($paramValue) {
                        $allParams[$paramKey] = $paramValue;
                    }
                }
            }
            $queryParams = http_build_query((array) $allParams);
        }

        try {
            $response = $this->guzzle->request(
                'GET',
                "activity?$queryParams",
                // if auth would be needed, could be like that:
                // [
                //     'headers' => [
                //         'Authorization' =>
                //             'Bearer ' . $this->auth->getAccessToken(),
                //         'Version' => '2.0',
                //     ],
                // ]
            );
            $data = json_decode($response->getBody());

            if (!$data) {
                throw new \Exception(sprintf(__('User activity fetch error: %s'), 'No data'));
            }

            if (is_object($data) && property_exists($data, 'error')) {
                throw new \Exception(sprintf(__('User activity fetch error: %s'), $data->error));
            }

            return $data->activity;
        } catch (RequestException $e) {
            error_log(json_encode([
                '[USERACTIVITIES] Guzzle Exception' => $e->getMessage()
            ]));

            return $e->getMessage();
        }
    }
}
