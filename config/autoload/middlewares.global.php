<?php

use Zend\Expressive\Helper;

return [
    'dependencies'        => [
        'factories' => [
            Helper\ServerUrlMiddleware::class => Helper\ServerUrlMiddlewareFactory::class,
            Helper\UrlHelperMiddleware::class => Helper\UrlHelperMiddlewareFactory::class,
            Web\Middleware\Layout::class      => Web\Factory\Middleware\LayoutFactory::class,
        ],
    ],
    // This can be used to seed pre- and/or post-routing middleware
    'middleware_pipeline' => [
        'always' => [
            'middleware' => [
                // Execute on every request: bootstrapping, pre-conditions, modifications to outgoing responses etc.
                \Zend\Stratigility\Middleware\OriginalMessages::class,
                \Zend\Stratigility\Middleware\ErrorHandler::class,
                \Zend\Expressive\Helper\ServerUrlMiddleware::class
            ],
            'priority'   => 10000,
        ],

        'routing' => [
            'middleware' => [
                Zend\Expressive\Container\ApplicationFactory::ROUTING_MIDDLEWARE,

                \Zend\Expressive\Middleware\ImplicitHeadMiddleware::class,
                \Zend\Expressive\Middleware\ImplicitOptionsMiddleware::class,
                \Zend\Expressive\Helper\UrlHelperMiddleware::class,
                \Web\Middleware\Layout::class,
                // Introspect the routing results; this might include: route-based authentication and validation etc.

                Zend\Expressive\Container\ApplicationFactory::DISPATCH_MIDDLEWARE,
            ],
            'priority'   => 1,
        ],
    ],
];
