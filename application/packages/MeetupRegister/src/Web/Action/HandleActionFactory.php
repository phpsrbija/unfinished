<?php

namespace MeetupRegister\Web\Action;

use Interop\Container\ContainerInterface;
use MeetupRegister\Service\RegisterService;
use Zend\Expressive\Router\RouterInterface as Router;
use Zend\Expressive\Template\TemplateRendererInterface as Template;

class HandleActionFactory
{
    public function __invoke(ContainerInterface $container): HandleFormAction
    {
        return new HandleFormAction(
            $container->get(RegisterService::class),
            $container->get(Router::class),
            $container->get(Template::class)
        );
    }
}