<?php

namespace Web\Factory\Action;

use ContactUs\Service\ContactUsService;
use Interop\Container\ContainerInterface;
use Web\Action\ContactUsAction;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class ContactUsAction
 *
 * @package Web\Action
 * @author  Djordje Stojiljkovic <djordjestojilljkovic@gmail.com>
 */
class ContactUsFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @return ContactUsAction
     */
    public function __invoke(ContainerInterface $container): ContactUsAction
    {
        return new ContactUsAction(
            $container->get(TemplateRendererInterface::class),
            $container->get(ContactUsService::class),
            $container->get(RouterInterface::class)
        );
    }
}