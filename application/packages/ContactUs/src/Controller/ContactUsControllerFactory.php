<?php

declare(strict_types=1);

namespace ContactUs\Controller;

use ContactUs\Service\ContactUsService;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class ContactUsControllerFactory
 *
 * @package ContactUs\Controller
 * @author  Djordje Stojiljkovic <djordjestojilljkovic@gmail.com>
 */
class ContactUsControllerFactory
{
    /**
     * @param  ContainerInterface  $container
     *
     * @return ContactUsController
     */
    public function __invoke(ContainerInterface $container): ContactUsController
    {
        return new ContactUsController(
            $container->get(TemplateRendererInterface::class),
            $container->get(RouterInterface::class),
            $container->get(ContactUsService::class)
        );
    }
}
