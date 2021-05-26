<?php

namespace Trykoszko\Container;

use DI\ContainerBuilder;
use function DI\factory;
use Psr\Container\ContainerInterface;

/**
 * Dependency Injection container
 */
class Main
{
    public $container;

    public function __construct()
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions([
            'GuzzleClient' => factory(function () {
                return new \GuzzleHttp\Client([
                    'base_uri' => 'http://www.boredapi.com/api/',
                ]);
            }),
            'Twig' => factory(function() {
                return new \Trykoszko\Twig\Main();
            }),
            'Auth' => factory(function () {
                return new \Trykoszko\Api\Auth();
            }),
            'Api' => factory(function (ContainerInterface $c) {
                return new \Trykoszko\Api\Main(
                    $c->get('GuzzleClient'),
                    $c->get('Auth')
                );
            }),
            'DataProvider' => factory(function (ContainerInterface $c) {
                return new \Trykoszko\DataProvider\Main($c->get('Api'));
            }),
            'WC' => factory(function(ContainerInterface $c) {
                return new \Trykoszko\WooCommerce\Main(
                    $c->get('Twig'),
                    $c->get('DataProvider')
                );
            })
        ]);
        $this->container = $containerBuilder->build();
    }

    public function getInstance()
    {
        return $this->container;
    }
}
