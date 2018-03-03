<?php

declare(strict_types=1);

namespace Register\Action;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class RegisterActionFactory
 */
class RegisterActionFactory
{
    /**
     * @param ContainerInterface $container
     * @return RegisterAction
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): RegisterAction
    {
        return new RegisterAction(
            $container->get(TemplateRendererInterface::class)
        );
    }
}
