<?php

namespace Web\Factory\Action;

use Web\Action\IndexAction;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class IndexFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new IndexAction(
            $container->get(TemplateRendererInterface::class)
        );
    }
}
