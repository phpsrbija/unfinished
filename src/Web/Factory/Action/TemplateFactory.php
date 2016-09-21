<?php

namespace Web\Factory\Action;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class TemplateFactory
{
    public function __invoke(ContainerInterface $container, $requestedName)
    {
        // check if class exist
        
        return new $requestedName(
            $container->get(TemplateRendererInterface::class)
        );
    }
}
