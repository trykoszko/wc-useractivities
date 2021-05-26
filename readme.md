# WC User Activities

A WordPress plugin (WooCommerce extension) used to fetch and display API data and assign to user

Note: only non-development dependencies are inside ./vendor.

## Installation

1. install WooCommerce in your WordPress install
2. download and install this plugin in your WordPress install
3. refresh permalinks by going to Settings -> Permalinks and clicking 'Save'

## User Tutorial

1. Register/Login to a website
2. Go to WooCommerce `My Account` page
3. Go to `Activities` tab on the left
4. You already should see an `Activity Idea`, but for better fit, submit your preferred activity types
5. Your `Activity Idea` for today is visible

## Development / Testing

- edit `./tests/api.suite.yml` and add correct `.env.testing`
- run `composer install` to install development dependencies
- run `composer test` to run tests

## Used dependencies
- php-di/php-di - dependency injection container
- twig/twig - templating
- guzzlehttp/guzzle - http requests
- wp-browser - acceptance/integration/unit test suite tool [[website]](https://wpbrowser.wptestkit.dev/)
