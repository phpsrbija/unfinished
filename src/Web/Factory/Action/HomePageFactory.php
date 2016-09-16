<?php

namespace Web\Factory\Action;

use Web\Action\HomePageAction;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class HomePageFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new HomePageAction(
            $container->get(TemplateRendererInterface::class)
        );
    }
}
