<?php

declare(strict_types=1);

namespace Register\Action;

use Interop\Container\ContainerInterface;
use Register\Service\RegisterService;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class HandleRegisterActionFactory
 */
class HandleRegisterActionFactory
{
    /**
     * @param ContainerInterface $container
     * @return HandleRegisterAction
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): HandleRegisterAction
    {
        return new HandleRegisterAction(
            $container->get(RegisterService::class),
            $container->get(TemplateRendererInterface::class)
        );
    }
}
