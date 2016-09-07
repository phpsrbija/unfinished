<?php

use Zend\Expressive\Helper;

return [
    'dependencies'        => [
        'factories' => [
            Helper\ServerUrlMiddleware::class   => Helper\ServerUrlMiddlewareFactory::class,
            Helper\UrlHelperMiddleware::class   => Helper\UrlHelperMiddlewareFactory::class,

            // Register custom Error Middlewares
            App\Middleware\Error::class         => App\Middleware\ErrorFactory::class,
            App\Middleware\ErrorNotFound::class => App\Middleware\ErrorNotFoundFactory::class,
        ],
    ],
    // This can be used to seed pre- and/or post-routing middleware
    'middleware_pipeline' => [
        // An array of middleware to register. Each item is of the following
        // specification:
        //
        // [
        //  Required:
        //     'middleware' => 'Name or array of names of middleware services and/or callables',
        //  Optional:
        //     'path'     => '/path/to/match', // string; literal path prefix to match
        //                                     // middleware will not execute
        //                                     // if path does not match!
        //     'error'    => true, // boolean; true for error middleware
        //     'priority' => 1, // int; higher values == register early;
        //                      // lower/negative == register last;
        //                      // default is 1, if none is provided.
        // ],
        //
        // While the ApplicationFactory ignores the keys associated with
        // specifications, they can be used to allow merging related values
        // defined in multiple configuration files/locations. This file defines
        // some conventional keys for middleware to execute early, routing
        // middleware, and error middleware.
        'always' => [
            'middleware' => [
                // Add more middleware here that you want to execute on
                // every request:
                // - bootstrapping
                // - pre-conditions
                // - modifications to outgoing responses
                Helper\ServerUrlMiddleware::class,
            ],
            'priority'   => 10000,
        ],

        'routing' => [
            'middleware' => [
                Zend\Expressive\Container\ApplicationFactory::ROUTING_MIDDLEWARE,
                Helper\UrlHelperMiddleware::class,
                // Add more middleware here that needs to introspect the routing
                // results; this might include:
                // - route-based authentication
                // - route-based validation
                // - etc.
                Zend\Expressive\Container\ApplicationFactory::DISPATCH_MIDDLEWARE,
            ],
            'priority'   => 1,
        ],

        'error404' => [
            'middleware' => [App\Middleware\ErrorNotFound::class],
            'priority'   => -1,
        ],

        'error' => [
            'middleware' => [App\Middleware\Error::class],
            'error'      => true,
            'priority'   => -10000,
        ],

    ],
];
