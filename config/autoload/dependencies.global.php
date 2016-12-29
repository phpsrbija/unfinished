<?php

// Provide application wide services
return [
    'dependencies' => [
        'invokables' => [
            Zend\Expressive\Helper\ServerUrlHelper::class => Zend\Expressive\Helper\ServerUrlHelper::class,
            Zend\Expressive\Router\RouterInterface::class => Zend\Expressive\Router\ZendRouter::class,
        ],
        'factories'  => [
            // Default factories
            Zend\Db\Adapter\Adapter::class                            => Zend\Db\Adapter\AdapterServiceFactory::class,
            'session'                                                 => Core\Factory\SessionFactory::class,
            Zend\Expressive\Application::class                        => Zend\Expressive\Container\ApplicationFactory::class,
            Zend\Expressive\Helper\UrlHelper::class                   => Zend\Expressive\Helper\UrlHelperFactory::class,
            Zend\Expressive\Template\TemplateRendererInterface::class => Zend\Expressive\ZendView\ZendViewRendererFactory::class,
            Zend\View\HelperPluginManager::class                      => Zend\Expressive\ZendView\HelperPluginManagerFactory::class,

            // Services
            Core\Service\AdminUserService::class                      => Core\Factory\Service\AdminUserServiceFactory::class,
            Core\Service\TagService::class                            => Core\Factory\Service\TagServiceFactory::class,
            Core\Model\Repository\ArticleRepositoryInterface::class   => Core\Factory\Model\Repository\ArticleRepositoryFactory::class,

            // Mappers
            Core\Mapper\AdminUsersMapper::class                       => Core\Factory\MapperFactory::class,
            Core\Mapper\ArticleMapper::class                          => Core\Factory\MapperFactory::class,
            Core\Mapper\TagsMapper::class                             => Core\Factory\MapperFactory::class,
        ],
    ],
];
