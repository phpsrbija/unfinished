<?php
declare(strict_types = 1);
namespace Core\Factory\Middleware;

use Core\Middleware\Error;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class ErrorFactory
{
    /**
     * Executed when factory invoked.
     *
     * @param ContainerInterface $container container
     *
     * @return Error
     */
    public function __invoke(ContainerInterface $container) : Error
    {
        return new Error(
            $container->get(TemplateRendererInterface::class)
        );
    }
}
