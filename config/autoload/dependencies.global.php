<?php

// Provide application wide services
return [
    'dependencies' => [
        'invokables' => [
            Zend\Expressive\Helper\ServerUrlHelper::class => Zend\Expressive\Helper\ServerUrlHelper::class,
            Zend\Expressive\Router\RouterInterface::class => Zend\Expressive\Router\ZendRouter::class,
        ],
        'factories'  => [
            Zend\Expressive\Application::class                        => Zend\Expressive\Container\ApplicationFactory::class,
            Zend\Expressive\Helper\UrlHelper::class                   => Zend\Expressive\Helper\UrlHelperFactory::class,
            Zend\Expressive\Template\TemplateRendererInterface::class => Zend\Expressive\ZendView\ZendViewRendererFactory::class,
            Zend\View\HelperPluginManager::class                      => Zend\Expressive\ZendView\HelperPluginManagerFactory::class,

        ],
    ],
];
